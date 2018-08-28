<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/28
 * Time: 19:08
 * Comment: 入驻申请控制器
 */

namespace app\index\controller;

use app\index\model\Booster as BoosterModel;
use app\index\validate\Booster as BoosterValidate;
use think\Request;

class Booster extends BasicController {

    /**
     * 声明入驻申请模型
     * @var
     */
    protected $booster_model;

    /**
     * 声明入驻申请验证器
     * @var
     */
    protected $booster_validate;

    /**
     * 声明默认构造函数
     * Booster constructor.
     * @param Request|null $request
     */
    public function __construct(Request $request = null) {
        parent::__construct($request);
        $this->booster_model = new BoosterModel();
        $this->booster_validate = new BoosterValidate();
    }

    /**
     * 声明入驻申请api接口
     * @return \think\response\Json
     */
    public function apply() {
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

}