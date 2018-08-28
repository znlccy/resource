<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/27
 * Time: 16:28
 * Comment: 项目入驻控制器
 */

namespace app\admin\controller;

use app\admin\model\Admission as AdmissionModel;
use app\admin\validate\Admission as AdmissionValidate;
use think\Controller;
use think\Request;

class Admission extends Controller {

    /**
     * 声明入驻项目模型
     * @var
     */
    protected $admission_model;

    /**
     * 声明入驻项目验证器
     * @var
     */
    protected $admission_validate;

    /**
     * 声明入驻项目分页器
     * @var
     */
    protected $admission_page;

    /**
     * 默认构造函数
     * Admission constructor.
     * @param Request|null $request
     */
    public function __construct(Request $request = null) {
        parent::__construct($request);
        $this->admission_model = new AdmissionModel();
        $this->admission_validate = new AdmissionValidate();
        $this->admission_page = config('pagination');
    }

    /**
     * 加速器申请列表api接口
     * @return \think\response\Json
     * @throws \think\exception\DbException
     */
    public function entry() {

        //获取客户端提交的数据
        $id = request()->param('id');
        $mobile = request()->param('mobile');
        $company = request()->param('company');
        $industry = request()->param('industry');
        $duty = request()->param('duty');
        $name = request()->param('name');
        $email = request()->param('email');
        $status = request()->param('status');
        $create_start = request()->param('create_start');
        $create_end = request()->param('create_end');
        $update_start = request()->param('update_start');
        $update_end = request()->param('update_end');
        $page_size = request()->param('page_size');
        $jump_page = request()->param('jump_page');

        //验证数据
        $validate_data = [
            'id'            => $id,
            'mobile'        => $mobile,
            'company'       => $company,
            'industry'      => $industry,
            'duty'          => $duty,
            'name'          => $name,
            'email'         => $email,
            'status'        => $status,
            'create_start'  => $create_start,
            'create_end'    => $create_end,
            'update_start'  => $update_start,
            'update_end'    => $update_end,
            'page_size'     => $page_size,
            'jump_page'     => $jump_page
        ];

        //验证结果
        $result = $this->admission_validate->scene('entry')->check($validate_data);
        if (!$result) {
            return json([
                'code'      => '401',
                'message'   => $this->admission_validate->getError()
            ]);
        }

        //筛选条件
        $conditions = [];

        if ($id) {
            $conditions['id'] = $id;
        }
        if ($mobile) {
            $conditions['mobile'] = $mobile;
        }
        if ($company) {
            $conditions['company'] = ['like', '%' . $company .'%'];
        }
        if ($industry) {
            $conditions['industry'] = ['like', '%' . $industry . '%'];
        }
        if ($duty) {
            $conditions['duty'] = ['like', '%' . $duty . '%'];
        }
        if ($name) {
            $conditions['name'] = ['like', '%' . $name .'%'];
        }
        if ($email) {
            $conditions['email'] = ['like', '%' . $email . '%'];
        }
        if ($status || $status === 0) {
            $conditions['status'] = $status;
        }
        if ($create_start && $create_end) {
            $conditions['create_time'] = ['between time', [$create_start, $create_end]];
        }
        if ($update_start && $update_end) {
            $conditions['update_time'] = ['between time', [$update_start, $update_end]];
        }

        //返回结果
        $admission = $this->admission_model->where($conditions)
            ->order('id', 'desc')
            ->order('create_time', 'desc')
            ->paginate($page_size, false, ['page' => $jump_page]);

        if ($admission) {
            return json([
                'code'      => '200',
                'message'   => '查询数据成功',
                'data'      => $admission
            ]);
        } else {
            return json([
                'code'      => '404',
                'message'   => '查询数据失败'
            ]);
        }
    }

    /**
     * 加速器申请添加更新api接口
     * @return \think\response\Json
     */
    public function save() {

        //接收客户端提交过来的数据
        $id = request()->param('id');
        $name = request()->param('name');
        $company = request()->param('company');
        $industry = request()->param('industry');
        $duty = request()->param('duty');
        $email = request()->param('email');
        $plan = request()->file('plan');
        $plan_name = '';
        // 移动图片到框架应用根目录/public/images
        if ($plan) {
            $info = $plan->move(ROOT_PATH . 'public' . DS . 'images');
            if ($info) {
                //成功上传后，获取上传信息
                //输出文件保存路径
                $sub_path = str_replace('\\', '/', $info->getSaveName());
                $plan  = '/images/' . $sub_path;
                $plan_name = $info->getFilename();
            }
        }

        //验证数据
        $validate_data = [
            'id'        => $id,
            'name'      => $name,
            'company'   => $company,
            'industry'  => $industry,
            'duty'      => $duty,
            'email'     => $email,
            'plan'      => $plan,
            'plan_name' => $plan_name
        ];

        //验证结果
        $result = $this->admission_validate->scene('save')->check($validate_data);
        if (!$result) {
            return json([
                'code'      => '401',
                'message'   => $this->admission_validate->getError()
            ]);
        }

        if (empty($id)) {
            $operator_result = $this->admission_model->save($validate_data);
        } else {
            $operator_result = $this->admission_model->save($validate_data, ['id' => $id]);
        }

        if ($operator_result) {
            return json([
                'code'      => '200',
                'message'   => '操作数据成功',
            ]);
        } else {
            return json([
                'code'      => '401',
                'message'   => '操作数据失败'
            ]);
        }
    }

    /**
     * 查看入驻详情api接口
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
        $result = $this->admission_validate->scene('detail')->check($validate_data);
        if (!$result) {
            return json([
                'code'      => '401',
                'message'   => $this->admission_validate->getError()
            ]);
        }

        //返回数据
        $star = $this->admission_model->where('id', $id)->find();
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
     * 入驻项目删除api接口
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
        $result = $this->admission_validate->scene('delete')->check($validate_data);
        if (!$result) {
            return json([
                'code'      => '401',
                'message'   => $this->admission_validate->getError()
            ]);
        }

        //返回结果
        $delete = $this->admission_model->where('id', $id)->delete();
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
     * 项目入驻审核api接口
     */
    public function auditor() {

        //获取客户端提交过来的数据
        $id = request()->param('id/a');

        //验证数据
        $validate_data = [
            'id'        => $id,
            'status'    => 1
        ];

        //验证结果
        $result = $this->admission_validate->scene('auditor')->check($validate_data);
        if (!$result) {
            return json([
                'code'      => '401',
                'message'   => $this->admission_validate->getError()
            ]);
        }

        $operator_result = false;
        for($i=0; $i< count($id); $i++) {
            $data['id'] = (int)$id[$i];
            $data['status'] = 1;
            $operator_result = $this->admission_model->update($data);
        }

        if ($operator_result) {
            return json([
                'code'      => '200',
                'message'   => '审核成功'
            ]);
        }
    }

    /**
     * 项目入驻下载api接口
     */
    public function download() {

        //获取客户端提交过来的数据
        $id = request()->param('id');

        //验证数据
        $validate_data = [
            'id'        => $id
        ];

        //验证结果
        $result = $this->admission_validate->scene('download')->check($validate_data);
        if (!$result) {
            return json([
                'code'      => '401',
                'message'   => $this->admission_validate->getError()
            ]);
        }

        //查询数据
        $admission = $this->admission_model->where('id', $id)->find();
        $file_dir = ROOT_PATH . 'public';
        $file_name = $admission['plan_name'];
        if ($admission) {
            if (file_exists($file_dir . $admission['plan'])) {
                //打开文件
                $file = fopen($file_dir . $admission['plan'], 'r');
                //输入文件标签
                header("Content-type: application/octet-stream");
                header("Accept-Ranges: bytes");
                header("Accept-Length: " . filesize($file_dir . $admission['plan']));
                header("Content-Disposition:attachment;filename=" . $file_name);
                ob_clean();
                flush();
                echo fread($file, filesize($file_dir . $admission['plan']));
                fclose($file);
                exit();
            } else {
                return json([
                    'code'      => '404',
                    'message'   => '文件不存在'
                ]);
            }
        }

    }

}