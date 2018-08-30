<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/29
 * Time: 15:04
 * Comment: 加速器申请验证器
 */

namespace app\index\validate;

class Booster extends BasicValidate {

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
        'mobile'    => 'regex:mobile|length:11|number',
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
        'mobile'    => '手机号码',
        'status'    => '状态',
        'apply_time'=> '申请日期',
        'reason'    => '商业企划书',
    ];

    //验证场景
    protected $scene = [
        'index'     => ['page_size' => 'number', 'jump_page' => 'number'],
        'apply'     => ['id' => 'number', 'name' => 'require|max:255', 'company' => 'require|max:255', 'industry' => 'require|max:255', 'duty' => 'require|max:255', 'email' => 'require|email', 'mobile' => 'require|regex:mobile|length:11|number','status' => 'number', 'reason' => 'require|max:255']
    ];
}