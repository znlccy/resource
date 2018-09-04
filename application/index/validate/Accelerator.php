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

    //验证规则
    protected $rule = [
        'id'        => 'number',
        'name'      => 'max:255',
        'company'   => 'max:255',
        'industry'  => 'max:255',
        'duty'      => 'max:255',
        'email'     => 'email',
        'plan'      => 'fileExt:rar,zip|fileSize:5M',
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
        'plan'      => '商业企划书',
    ];

    //验证场景
    protected $scene = [
        'index'     => ['page_size' => 'number', 'jump_page' => 'number'],
        'apply'     => [ 'name' => 'require|max:255', 'company' => 'require|max:255', 'industry' =>'require|max:255', 'duty' => 'require|max:255', 'email' => 'require|email', 'mobile' => 'require|regex:mobile|length:11|number', 'status' => 'number', 'plan' => 'require'],
        'detail'    => ['id' => 'require|number']
    ];
}