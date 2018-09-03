<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/27
 * Time: 16:43
 * Comment: 入驻项目验证器
 */

namespace app\admin\validate;

class Admission extends BasisValidate {

    //手机验证正则表达式
    protected $regex = [ 'mobile' => '/^(13[0-9]|14[579]|15[0-3,5-9]|16[6]|17[0135678]|18[0-9]|19[89])\d{8}$/'];

    //验证规则
    protected $rule = [
        'id'            => 'number',
        'mobile'        => 'length:11|number|regex:mobile',
        'company'       => 'max:255',
        'industry'      => 'max:255',
        'duty'          => 'max:255',
        'name'          => 'max:255',
        'email'         => 'email',
        'status'        => 'number|in:0,1',
        'create_start'  => 'date',
        'create_end'    => 'date',
        'update_start'  => 'date',
        'update_end'    => 'date',
        'page_size'     => 'number',
        'jump_page'     => 'number'
    ];

    //验证消息
    protected $message = [

    ];

    //验证字段
    protected $field = [
        'id'            => '项目入驻主键',
        'mobile'        => '项目入驻手机账号',
        'company'       => '项目入驻公司',
        'industry'      => '项目入驻行业',
        'duty'          => '项目入驻职称',
        'name'          => '项目入驻名称',
        'email'         => '项目入驻邮箱',
        'status'        => '项目入驻状态',
        'create_start'  => '项目入驻创建起始时间',
        'create_end'    => '项目入驻创建截止时间',
        'update_start'  => '项目入驻更新起始时间',
        'update_end'    => '项目入驻更新截止时间',
        'page_size'     => '分页大小',
        'jump_page'     => '跳转页'
    ];

    //验证场景
    protected $scene = [
        'entry'     => ['id' => 'number', 'mobile' => 'regex:mobile|length:11|number', 'company' => 'max:255', 'industry' => 'max:255', 'duty' => 'max:255', 'name' => 'max:255', 'email' => 'email', 'status' => 'number|in:0,1', 'create_start' => 'date', 'create_end' => 'date', 'update_start' => 'date', 'update_end' => 'date', 'page_size' => 'number', 'jump_page' => 'number'],
        'save'      => ['id' => 'number', 'name' => 'require|max:255', 'company' => 'require|max:255', 'industry' => 'require|max:255', 'duty' => 'require|max:255', 'email' => 'require|email', 'plan' => 'require'],
        'detail'    => ['id' => 'require|number'],
        'delete'    => ['id' => 'require|number']
    ];
}