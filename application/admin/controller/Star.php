<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/27
 * Time: 13:20
 * Comment: 明星项目控制器
 */

namespace app\admin\controller;

use app\admin\model\Star as StarModel;
use app\admin\validate\Star as StarValidate;
use think\Request;

class Star extends BasisController {

    /**
     * 声明明星模型
     * @var
     */
    protected $star_model;

    /**
     * 声明明星验证器
     * @var
     */
    protected $star_validate;

    /**
     * @var
     */
    protected $star_page;

    /**
     * Star constructor.
     * @param Request|null $request
     */
    public function __construct(Request $request = null) {
        parent::__construct($request);
        $this->star_model = new StarModel();
        $this->star_validate = new StarValidate();
        $this->star_page = config('pagination');
    }

    public function entry() {

        //获取客户端提交过来的数据
        $id = request()->param('id');
        $name = request()->param('name');
        $introduce = request()->param('introduce');
        $create_start = request()->param('create_start');
        $create_end = request()->param('create_end');
        $update_start = request()->param('update_start');
        $update_end = request()->param('update_end');
        $sort = request()->param('sort');
        $status = request()->param('status');
        $page_size = request()->param('page_size', $this->star_page['PAGE_SIZE']);
        $jump_page = request()->param('jump_page', $this->star_page['JUMP_PAGE']);

        //验证数据
        $validate_data = [
            'id'            => $id,
            'name'          => $name,
            'introduce'     => $introduce,
            'create_start'  => $create_start,
            'create_end'    => $create_end,
            'update_start'  => $update_start,
            'update_end'    => $update_end,
            'sort'          => $sort,
            'status'        => $status,
            'page_size'     => $page_size,
            'jump_page'     => $jump_page
        ];

        //验证结果
        $result = $this->star_validate->scene('entry')->check($validate_data);
        if (!$result) {
            return json([
                'code'      => '401',
                'message'   => $this->star_validate->getError()
            ]);
        }

        //条件筛选
        $conditions = [];

        if ($id) {
            $conditions['id'] = $id;
        }
        if ($name) {
            $conditions['name'] = ['like', '%' . $name . '%'];
        }
        if ($introduce) {
            $conditions['introduce'] = ['like', '%' . $introduce . '%'];
        }
        if ($create_start && $create_end) {
            $conditions['create_time'] = ['between time', [$create_start, $create_end]];
        }
        if ($update_start && $update_end) {
            $conditions['update_time'] = ['between time', [$update_start, $update_end]];
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
        if ($sort) {
            $conditions['sort'] = $sort;
        }

        //返回数据
        $star = $this->star_model->where($conditions)
            ->order('sort', 'desc')
            ->order('id', 'desc')
            ->paginate($page_size, false, ['page' => $jump_page]);

        return json([
            'code'      => '200',
            'message'   => '获取明星项目列表成功',
            'data'      => $star
        ]);
    }

    /**
     * 明星项目添加更新api接口
     * @return \think\response\Json
     */
    public function save() {
        /* 获取前端提交的数据 */
        $id           = request()->param('id');
        $name         = request()->param('name');
        $introduce    = request()->param('introduce');
        $picture      = request()->file('picture');
        $status       = request()->param('status', 1);
        $sort         = request()->param('sort');

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
            'introduce'     => $introduce,
            'picture'       => $picture,
            'status'        => $status,
            'sort'          => $sort
        ];

        //验证结果
        $result = $this->star_validate->scene('save')->check($validate_data);
        if (!$result) {
            return json([
                'code'      => '401',
                'message'   => $this->star_validate->getError()
            ]);
        }
        if (empty($id)) {
            $result  = $this->star_model->save($validate_data);
        } else {
            if (empty($picture)) {
                unset($validate_data['picture']);
            }
            $result  = $this->star_model->save($validate_data, ['id' => $id]);
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
        $result = $this->star_validate->scene('detail')->check($validate_data);
        if (!$result) {
            return json([
                'code'      => '401',
                'message'   => $this->star_validate->getError()
            ]);
        }

        //返回数据
        $star = $this->star_model->where('id', $id)->find();
        if ($star) {
            return json([
                'code'      => '200',
                'message'   => '查询数据成功',
                'data'      => $star
            ]);
        } else {
            return json([
                'code'      => '404',
                'message'   => '查询数据失败,数据不存在'
            ]);
        }
    }

    /**
     * 删除明星项目api接口
     * @return \think\response\Json
     */
    public function delete() {
        //获取客户端提交过来的数据
        $id = request()->param('id');

        //验证数据
        $validate_data = [
            'id'            => $id
        ];

        //验证结果
        $result = $this->star_validate->scene('delete')->check($validate_data);
        if (!$result) {
            return json([
                'code'      => '401',
                'message'   => $this->star_validate->getError()
            ]);
        }

        //返回结果
        $delete = $this->star_model->where('id', $id)->delete();
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
}