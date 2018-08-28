<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/27
 * Time: 14:09
 * Comment: 加速器控制器
 */

namespace app\index\controller;

use app\index\model\Accelerator as AcceleratorModel;
use app\index\validate\Accelerator as AcceleratorValidate;
use app\index\model\Admission as AdmissionModel;
use app\index\validate\Admission as AdmissionValidate;
use think\Request;

class Accelerator extends BasicController {

    /**
     * 声明加速器模型
     * @var
     */
    protected $accelerator_model;

    /**
     * 声明加速器申请模型
     * @var
     */
    protected $admission_model;

    /**
     * 声明加速器验证器
     * @var
     */
    protected $accelerator_validate;

    /**
     * 声明加速器申请验证器
     * @var
     */
    protected $admission_validate;

    /**
     * 声明加速器分页器
     * @var
     */
    protected $accelerator_page;

    /**
     * 声明默认构造函数
     * Accelerator constructor.
     * @param Request|null $request
     */
    public function __construct(Request $request = null) {
        parent::__construct($request);
        $this->accelerator_model = new AcceleratorModel();
        $this->admission_model = new AdmissionModel();
        $this->accelerator_validate = new AcceleratorValidate();
        $this->admission_validate = new AcceleratorValidate();
        $this->accelerator_page = config('pagination');
    }

    /**
     * 获取加速器列表api接口
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function index() {

        //返回给客户端最新的数据
        $accelerator = $this->accelerator_model
            ->order('id', 'desc')
            ->order('create_time', 'desc')
            ->limit(4)
            ->select();

        //返回给客户端数据
        if ($accelerator) {
            return json([
                'code'      => '200',
                'message'   => '获取加速器列表成功',
                'data'      => $accelerator
            ]);
        } else {
            return json([
                'code'      => '404',
                'message'   => '获取加速器列表失败'
            ]);
        }
    }

    /**
     * 加速器申请api接口
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
}