<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/27
 * Time: 14:08
 * Comment: 加速器控制器
 */

namespace app\admin\controller;

use think\Request;
use app\admin\model\Accelerator as AcceleratorModel;
use app\admin\model\UserAccelerator as UserAcceleratorModel;
use app\admin\model\Category as CategoryModel;
use app\admin\validate\Accelerator as AcceleratorValidate;

class Accelerator extends BasisController {

    /**
     * 声明加速器模型
     * @var
     */
    protected $accelerator_model;

    /**
     * 分类模型
     * @var
     */
    protected $category_model;

    /**
     * 用户加速器模型
     * @var
     */
    protected $user_accelerator_model;

    /**
     * 声明加速器验证器
     * @var
     */
    protected $accelerator_validate;

    /**
     * 声明加速器分页器
     * @var
     */
    protected $accelerator_page;

    /**
     * 默认构造函数
     * Accelerator constructor.
     * @param Request|null $request
     */
    public function __construct(Request $request = null) {
        parent::__construct($request);
        $this->accelerator_model = new AcceleratorModel();
        $this->category_model = new CategoryModel();
        $this->user_accelerator_model = new UserAcceleratorModel();
        $this->accelerator_validate = new AcceleratorValidate();
        $this->accelerator_page = config('pagination');
    }

    /**
     * 加速资源列表api接口
     * @return \think\response\Json
     * @throws \think\exception\DbException
     */
    public function entry() {

        //获取客户端提交过来的数据
        $id = request()->param('id');
        $name = request()->param('name');
        $description = request()->param('description');
        $price_start = request()->param('price_start');
        $price_end = request()->param('price_end');
        $recommend = request()->param('recommend');
        $status = request()->param('status');
        $address = request()->param('address');
        $create_start = request()->param('create_start');
        $create_end = request()->param('create_end');
        $update_start = request()->param('update_start');
        $update_end = request()->param('update_end');
        $publish_start = request()->param('publish_start');
        $publish_end = request()->param('publish_end');
        $page_size = request()->param('page_size', $this->accelerator_page['PAGE_SIZE']);
        $jump_page = request()->param('jump_page', $this->accelerator_page['JUMP_PAGE']);

        //验证数据
        $validate_data = [
            'id'            => $id,
            'name'          => $name,
            'description'   => $description,
            'price_start'   => $price_start,
            'price_end'     => $price_end,
            'recommend'     => $recommend,
            'status'        => $status,
            'address'       => $address,
            'create_start'  => $create_start,
            'create_end'    => $create_end,
            'update_start'  => $update_start,
            'update_end'    => $update_end,
            'publish_start' => $publish_start,
            'publish_end'   => $publish_end,
            'page_size'     => $page_size,
            'jump_page'     => $jump_page,
        ];

        //验证结果
        $result = $this->accelerator_validate->scene('entry')->check($validate_data);
        if (!$result) {
            return json([
                'code'      => '401',
                'message'   => $this->accelerator_page->getError()
            ]);
        }

        //筛选条件
        $conditions = [];
        if ($id) {
            $conditions['id'] = $id;
        }
        if ($name) {
            $conditions['name'] = ['like', '%' . $name .'%'];
        }
        if ($description) {
            $conditions['description'] = ['like', '%' . $description .'%'];
        }
        if ($price_start && $price_end) {
            $conditions['price'] = ['between',[$price_start, $price_end]];
        }
        if (is_null($recommend)) {
            $conditions['recommend'] = ['in',[0,1]];
        } else {
            switch ($recommend) {
                case 0:
                    $conditions['recommend'] = $recommend;
                    break;
                case 1:
                    $conditions['recommend'] = $recommend;
                    break;
                default:
                    break;
            }
        }
        if (is_null($status)) {
            $conditions['status'] = ['in',[0,1]];
        } else {
            switch ($status) {
                case 0:
                    $conditions['status'] = $status;
                    break;
                case 1:
                    $conditions['status'] = $status;
                    break;
                default:
                    break;
            }
        }
        if ($address) {
            $conditions['address'] = ['like', '%' . $address . '%'];
        }
        if ($create_start && $create_end) {
            $conditions['create_time'] = ['between time', [$create_start, $create_end]];
        }
        if ($update_start && $update_end) {
            $conditions['update_time'] = ['between time', [$update_start, $update_end]];
        }
        if ($publish_start && $publish_end) {
            $conditions['publish_time'] = ['between time', [$publish_start, $publish_end]];
        }

        //返回结果
        $service = $this->accelerator_model->where($conditions)
            ->order('id', 'desc')
            ->paginate($page_size, false, ['page' => $jump_page]);
        return json([
            'code'      => '200',
            'message'   => '获取服务列表成功',
            'data'      => $service
        ]);

    }

    /**
     * 加速资源保存更新api接口
     * @return \think\response\Json
     */
    public function save() {

        /* 获取前端提交的数据 */
        $id           = request()->param('id');
        $name         = request()->param('name');
        $description  = request()->param('description');
        $picture      = request()->file('picture');
        $price        = request()->param('price');
        $recommend    = request()->param('recommend', 1);
        $address      = request()->param('address');
        $publish_time = date('Y-m-d H:i:s', time());
        $status       = request()->param('status', 1);
        $rich_text    = request()->param('rich_text');

        // 移动图片到框架应用根目录/public/images
        if ($picture) {
            $info = $picture->move(ROOT_PATH . 'public' . DS . 'images');
            if ($info) {
                //成功上传后，获取上传信息
                //输出文件保存路径
                $sub_path = str_replace('\\', '/', $info->getSaveName());
                $picture  = '/images/' . $sub_path;
            }
        }

        //验证数据
        $validate_data = [
            'id'            => $id,
            'name'          => $name,
            'description'   => $description,
            'picture'       => $picture,
            'price'         => $price,
            'recommend'     => $recommend,
            'address'       => $address,
            'publish_time'  => $publish_time,
            'status'        => $status,
            'rich_text'     => $rich_text
        ];

        //验证结果
        $result = $this->accelerator_validate->scene('save')->check($validate_data);
        if (!$result) {
            return json([
                'code'      => '401',
                'message'   => $this->accelerator_validate->getError()
            ]);
        }
        if (empty($id)) {
            $result  = $this->accelerator_model->save($validate_data);
        } else {
            if (empty($picture)) {
                unset($validate_data['picture']);
            }
            $result  = $this->accelerator_model->save($validate_data, ['id' => $id]);
        }
        if ($result) {
            $data = ['code' => '200', 'message' => '保存成功!'];
            return json($data);
        } else {
            $data = ['code' => '404', 'message' => '保存失败'];
            return json($data);
        }
    }

    /**
     * 加速资源详情api接口
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function detail() {
        //获取客户端提交的数据
        $id = request()->param('id');

        //验证数据
        $validate_data = [
            'id'            => $id
        ];

        //验证结果
        $result = $this->accelerator_validate->scene('detail')->check($validate_data);
        if (!$result) {
            return json([
                'code'      => '401',
                'message'   => $this->accelerator_validate->getError()
            ]);
        }

        //返回数据
        $service = $this->accelerator_model->where('id', $id)->find();
        if ($service) {
            return json([
                'code'      => '200',
                'message'   => '查询数据成功',
                'data'      => $service
            ]);
        } else {
            return json([
                'code'      => '404',
                'message'   => '查询数据失败,数据不存在'
            ]);
        }
    }

    /**
     * 删除服务资源api接口
     */
    public function delete() {

        //获取客户端提交过来的数据
        $id = request()->param('id');

        //验证数据
        $validate_data = [
            'id'            => $id
        ];

        //验证结果
        $result = $this->accelerator_validate->scene('delete')->check($validate_data);
        if (!$result) {
            return json([
                'code'      => '401',
                'message'   => $this->accelerator_validate->getError()
            ]);
        }

        //返回结果
        $delete = $this->accelerator_model->where('id', $id)->delete();
        if ($delete) {
            return json([
                'code'      => '200',
                'message'   => '删除数据成功'
            ]);
        } else {
            return json([
                'code'      => '401',
                'message'   => '删除数据失败'
            ]);
        }
    }

    /**
     * 加速器报名列表api接口
     */
    public function apply_list() {
        /* 获取客户端提供的数据 */
        $id = request()->param('id');
        $apply_time_start = request()->param('apply_time_start');
        $apply_time_end = request()->param('apply_time_end');
        $company = request()->param('company');
        $industry = request()->param('industry');
        $duty = request()->param('duty');
        $username = request()->param('username');
        $mobile = request()->param('mobile');
        $email = request()->param('email');
        $status = request()->param('status');
        $page_size = request()->param('page_size', $this->accelerator_page['PAGE_SIZE']);
        $jump_page = request()->param('jump_page', $this->accelerator_page['JUMP_PAGE']);


        /* 验证数据 */
        $validate_data = [
            'id'              => $id,
            'page_size'       => $page_size,
            'jump_page'       => $jump_page,
            'apply_time_start'=> $apply_time_start,
            'apply_time_end'  => $apply_time_end,
            'company'         => $company,
            'industry'        => $industry,
            'duty'            => $duty,
            'username'        => $username,
            'mobile'          => $mobile,
            'email'           => $email,
            'status'          => $status
        ];

        //验证结果
        $result   = $this->accelerator_validate->scene('apply_list')->check($validate_data);
        if (!$result) {
            return json(['code' => '401', 'message' => $this->accelerator_validate->getError()]);
        }

        //筛选条件
        $conditions = [];

        if ($id) {
            $conditions['ua.accelerator_id'] = $id;
        }
        if ($apply_time_start && $apply_time_end) {
            $conditions['tu.apply_time'] = ['between time',[$apply_time_start, $apply_time_end]];
        }
        if ($company) {
            $conditions['tu.company'] = ['like', '%' . $company . '%'];
        }
        if ($industry) {
            $conditions['tu.industry'] = ['like', '%' . $industry . '%'];
        }
        if ($duty) {
            $conditions['tu.duty'] = ['like', '%' . $duty . '%'];
        }
        if ($username) {
            $conditions['tu.username'] = ['like', '%' . $username . '%'];
        }
        if ($email) {
            $conditions['tu.email'] = ['like', '%' . $email .'%'];
        }
        if ($mobile) {
            $conditions['tu.mobile'] = ['like', '%' . $mobile . '%'];
        }
        if (is_null($status)) {
            $conditions['tu.status'] = ['in',[0,1]];
        } else {
            switch ($status) {
                case 0:
                    $conditions['tu.status'] = $status;
                    break;
                case 1:
                    $conditions['tu.status'] = $status;
                    break;
                default:
                    break;
            }
        }

        /* 返回结果 */
        $result = $this->user_accelerator_model
            -> alias('ua')
            -> join('tb_user tu', 'ua.user_id = tu.id')
            -> join('tb_accelerator ta', 'ta.id = ua.accelerator_id')
            -> where($conditions)
            -> field('tu.mobile, ta.id as accelerator_id,ta.name as accelerator_name, ta.status, ta.apply_time, tu.username, tu.mobile, tu.email, tu.duty, tu.industry, tu.company')
            ->paginate($page_size, false, ['page' => $jump_page]);

        if ($result) {
            return json(['code' => '200', 'message' => '查询成功', 'data' => $result]);
        } else {
            return json(['code' => '404', 'message' => '查询失败']);
        }
    }

    /**
     * 加速器报名审核
     */
    public function auditor() {

        //接收客户端提交过来的数据
        $id     = request()->param('id');

        if(empty($id)) {
            return json(['code' => '401', 'message' => '加速器id不能为空']);
        }

        /* 验证规则 */
        $validate_data = [
            'id'     => $id,
            'status'     => 1
        ];

        //验证结果
        $result   = $this->accelerator_validate->scene('check')->check($validate_data);
        if (!$result) {
            return json(['code' => '401', 'message' => $this->accelerator_validate->getError()]);
        }

        //审核结果
        $accelerator = $this->accelerator_model->where('id', $id)->find();
        if ($accelerator['status'] == 1) {
            return json(['code' => '401', 'message' => '该加速器已经通过审核了']);
        } else {
            /* 审核结果 */
            $auditor_result = $this->accelerator_model->save($validate_data,['id' => $id]);
            if ($auditor_result) {
                return json(['code' => '200', 'message' => '审核通过']);
            } else {
                return json(['code' => '404', 'message' => '审核失败，数据库中可能没有这个加速器']);
            }
        }

    }

    /**
     * 加速器资源下拉列表api接口
     */
    public function spinner() {
        //获取数据库数据
        $category = $this->category_model->where('status','1')->field('id, name')->select();

        //返回结果
        if ($category) {
            return json([
                'code'      => '200',
                'message'   => '获取列表成功',
                'data'      => $category
            ]);
        } else {
            return json([
                'code'      => '404',
                'message'   => '获取列表失败'
            ]);
        }
    }

}