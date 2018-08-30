<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/27
 * Time: 19:31
 * Comment: 加速器申请控制器
 */

namespace app\admin\controller;

use app\admin\model\Booster as BoosterModel;
use app\admin\validate\Booster as BoosterValidate;
use think\Request;

class Booster extends BasisController {

    /**
     * 声明加速器申请模型
     * @var
     */
    protected $booster_model;

    /**
     * 声明加速器申请验证器
     * @var
     */
    protected $booster_validate;

    /**
     * 声明加速器申请分页器
     * @var
     */
    protected $booster_page;

    /**
     * 声明默认构造函数
     * Booster constructor.
     * @param Request|null $request
     */
    public function __construct(Request $request = null) {
        parent::__construct($request);
        $this->booster_model = new BoosterModel();
        $this->booster_validate = new BoosterValidate();
        $this->booster_page = config('pagination');
    }

    /**
     * 加速资源列表api接口
     * @return \think\response\Json
     * @throws \think\exception\DbException
     */
    public function entry() {

        //接收客户端提交过来的数据
        $id = request()->param('id');
        $apply_time_start = request()->param('apply_time_start');
        $apply_time_end = request()->param('apply_time_end');
        $accelerator_id = request()->param('accelerator_id');
        $mobile = request()->param('mobile');
        $company = request()->param('company');
        $industry = request()->param('industry');
        $duty = request()->param('duty');
        $name = request()->param('name');
        $email = request()->param('email');
        $status = request()->param('status');
        $create_start = request()->param('create_start');
        $create_end = request()->param('create_end');
        $page_size = request()->param('page_size', $this->booster_page['PAGE_SIZE']);
        $jump_page = request()->param('jump_page', $this->booster_page['JUMP_PAGE']);

        //验证数据
        $validate_data = [
            'id'                => $id,
            'apply_time_start'  => $apply_time_start,
            'apply_time_end'    => $apply_time_end,
            'accelerator_id'    => $accelerator_id,
            'mobile'            => $mobile,
            'company'           => $company,
            'industry'          => $industry,
            'duty'              => $duty,
            'name'              => $name,
            'email'             => $email,
            'status'            => $status,
            'create_start'      => $create_start,
            'create_end'        => $create_end,
            'page_size'         => $page_size,
            'jump_page'         => $jump_page
        ];

        //验证结果
        $result = $this->booster_validate->scene('entry')->check($validate_data);
        if (!$result) {
            return json([
                'code'      => '401',
                'message'   => $this->booster_validate->getError()
            ]);
        }

        //筛选条件
        $conditions = [];

        if ($id) {
            $conditions['id'] = $id;
        }
        if ($apply_time_start && $apply_time_end) {
            $conditions['apply_time'] = ['between time', [$apply_time_start, $apply_time_end]];
        }
        if ($accelerator_id) {
            $conditions['accelerator_id'] = $accelerator_id;
        }
        if ($mobile) {
            $conditions['mobile'] = $mobile;
        }
        if ($company) {
            $conditions['company'] = ['like', '%' . $company . '%'];
        }
        if ($industry) {
            $conditions['industry'] = ['like', '%' . $industry . '%'];
        }
        if ($duty) {
            $conditions['duty'] = ['like', '%' . $duty . '%'];
        }
        if ($name) {
            $conditions['name'] = ['like', '%' . $name . '%'];
        }
        if ($email) {
            $conditions['email'] = ['like', '%' . $email . '%'];
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
        if ($create_start && $create_end) {
            $conditions['create_time'] = ['between time', [$create_start, $create_end]];
        }

        //筛选结果
        $booster = $this->booster_model->where($conditions)
            ->paginate($page_size, false, ['page' => $jump_page]);

        return json([
            'code'      => '200',
            'message'   => '查询数据成功',
            'data'      => $booster
        ]);
    }

    /**
     * 加速器申请添加更新api接口
     * @return \think\response\Json
     */
    public function save() {

        //接收客户端提交过来的数据
        $id = request()->param('id');
        $accelerator_id = request()->param('accelerator_id');
        $mobile = request()->param('mobile');
        $company = request()->param('company');
        $industry = request()->param('industry');
        $duty = request()->param('duty');
        $name = request()->param('name');
        $email = request()->param('email');
        $status = request()->param('status');
        $apply_time = date('Y-m-d H:i:s', time());

        //验证数据
        $validate_data = [
            'id'            => $id,
            'accelerator_id'=> $accelerator_id,
            'mobile'        => $mobile,
            'company'       => $company,
            'industry'      => $industry,
            'duty'          => $duty,
            'name'          => $name,
            'email'         => $email,
            'status'        => $status,
            'apply_time'    => $apply_time
        ];

        //验证结果
        $result = $this->booster_validate->scene('save')->check($validate_data);
        if (!$result) {
            return json([
                'code'      => '401',
                'message'   => $this->booster_validate->getError()
            ]);
        }

        if (empty($id)) {
            $operator_result = $this->booster_model->save($validate_data);
        } else {
            $operator_result = $this->booster_model->save($validate_data, ['id' => $id]);
        }

        if ($operator_result) {
            return json([
                'code'      => '200',
                'message'   => '数据操作成功'
            ]);
        } else {
            return json([
                'code'      => '401',
                'message'   => '数据操作失败'
            ]);
        }

    }

    /**
     * 加速器申请api接口
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
        $result = $this->booster_validate->scene('detail')->check($validate_data);
        if (!$result) {
            return json([
                'code'      => '401',
                'message'   => $this->booster_validate->getError()
            ]);
        }

        //返回数据
        $booster = $this->booster_model->where('id', $id)->find();
        if ($booster) {
            return json([
                'code'      => '200',
                'message'   => '查询数据成功',
                'data'      => $booster
            ]);
        } else {
            return json([
                'code'      => '404',
                'message'   => '查询数据失败,数据不存在'
            ]);
        }
    }

    /**
     * 加速器资源删除api接口
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
        $result = $this->booster_validate->scene('delete')->check($validate_data);
        if (!$result) {
            return json([
                'code'      => '401',
                'message'   => $this->booster_validate->getError()
            ]);
        }

        //返回结果
        $delete = $this->booster_model->where('id', $id)->delete();
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
     * 加速器申请审核api接口
     */
    public function auditor() {

        //接收客户端提交过来的数据
        $id = request()->param('id/a');

        //验证数据
        $validate_data = [
            'id'        => $id,
            'status'    => 1
        ];

        //验证结果
        $result = $this->booster_validate->scene('auditor')->check($validate_data);
        if (!$result) {
            return json([
                'code'      => '401',
                'message'   => $this->booster_validate->getError()
            ]);
        }

        $operator_result = false;
        for($i=0; $i< count($id); $i++) {
            $data['id'] = (int)$id[$i];
            $data['status'] = 1;
            $operator_result = $this->booster_model->update($data);
        }

        if ($operator_result) {
            return json([
                'code'      => '200',
                'message'   => '审核成功'
            ]);
        }
    }

}

