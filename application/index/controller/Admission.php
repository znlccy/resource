<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/29
 * Time: 14:49
 * Comment: 入驻申请控制器
 */

namespace app\index\controller;

use app\index\model\Admission as AdmissionModel;
use app\index\validate\Admission as AdmissionValidate;
use think\Controller;
use think\Request;

class Admission extends Controller {

    /**
     * 声明入驻申请模型
     * @var
     */
    protected $admission_model;

    /**
     * 申明入驻申请验证器
     * @var
     */
    protected $admission_validate;

    /**
     * 默认构造函数
     * Admission constructor.
     * @param Request|null $request
     */
    public function __construct(Request $request = null) {
        parent::__construct($request);
        $this->admission_model = new AdmissionModel();
        $this->admission_validate = new AdmissionValidate();
    }

    /**
     * 入驻申请api接口
     * @return \think\response\Json
     */
    public function apply() {
        //接收客户端提交过来的数据
        $id = request()->param('id');
        $name = request()->param('name');
        $company = request()->param('company');
        $industry = request()->param('industry');
        $duty = request()->param('duty');
        $email = request()->param('email');
        $status = 0;
        $mobile = request()->param('mobile');
        $plan = request()->file('plan');
        $plan_name = '';
        $test = $this->fileHandle($plan);
        if ($test) {
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
        } else {
            return json([
                'code'      => '401',
                'message'   => '文件格式不对，支持zip和rar,或者文件上传大小超过5M'
            ]);
            exit();
        }

        //验证数据
        $validate_data = [
            'id'        => $id,
            'name'      => $name,
            'company'   => $company,
            'industry'  => $industry,
            'duty'      => $duty,
            'email'     => $email,
            'status'    => $status,
            'mobile'    => $mobile,
            'plan'      => $plan,
            'plan_name' => $plan_name
        ];

        //验证结果
        $result = $this->admission_validate->scene('apply')->check($validate_data);
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
     * 文件处理类
     * @param $file
     * @return bool|\think\response\Json
     */
    protected function fileHandle($file) {
        $checkExt = $file->validate(['ext'=>'zip,rar'])->check();
        if ($checkExt) {
            $checkSize =  $file->validate(['size'=>5*1024*1024])->check();
            if ($checkSize) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}