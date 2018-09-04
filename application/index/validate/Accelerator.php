<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/27
 * Time: 14:09
 * Comment: 加速器验证器
 */

namespace app\index\validate;

class Accelerator extends BasicValidate {

    //手机验证正则表达式
    protected $regex = [ 'mobile' => '/^(13[0-9]|14[579]|15[0-3,5-9]|16[6]|17[0135678]|18[0-9]|19[89])\d{8}$/'];

    //验证规则
    protected $rule = [
        'id'        => 'number',
        'name'      => 'max:255',
        'company'   => 'max:255',
        'industry'  => 'max:255',
        'duty'      => 'max:255',
        'email'     => 'email',
        'reason'    => 'max:255',
    ];

    //验证消息
    protected $message = [

    ];

    //验证字段
    protected $field = [
        'id'        => '加速器主键',
        'name'      => '资源名称',
        'company'   => '公司名称',
        'industry'  => '行业名称',
        'duty'      => '职务名称',
        'email'     => '电子邮箱',
        'reason'    => '申请理由',
    ];

    //验证场景
    protected $scene = [
        'index'     => ['page_size' => 'number', 'jump_page' => 'number'],
        'apply'     => [ 'name' => 'max:255', 'company' => 'max:255', 'industry' =>'max:255', 'duty' => 'max:255', 'email' => 'email', 'mobile' => 'regex:mobile|length:11|number', 'status' => 'number', 'reason' => 'require'],
        'detail'    => ['id' => 'require|number']
    ];
}