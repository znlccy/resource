<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/15
 * Time: 14:33
 * Comment: 成员验证器
 */

namespace app\admin\validate;

class User extends BasisValidate {

    //手机验证正则表达式
    protected $regex = [ 'mobile' => '/^(13[0-9]|14[579]|15[0-3,5-9]|16[6]|17[0135678]|18[0-9]|19[89])\d{8}$/'];

    //座机验证正则表达式
    protected $regexp = ['phone' => '/^(0[0-9]{2,3}/-)?([2-9][0-9]{6,7})+(/-[0-9]{1,4})?$/'];

    //验证规则
    protected $rule = [
        'page_size'     => 'number',
        'jump_page'     => 'number',
        'id'            => 'number',
        'status'        => 'number',
        'create_start'  => 'date',
        'create_end'    => 'date',
        'login_start'   => 'date',
        'login_end'     => 'date',
        'mobile'        => 'length:11|unique:tb_user',
        'username'      => 'max:50',
        'email'         => 'email',
        'company'       => 'max:80',
        'career'        => 'max:120',
        'occupation'    => 'max:200'
    ];

    //验证领域
    protected $field = [
        'page_size'     => '每页显示多少条数据',
        'jump_page'     => '跳转至第几页',
        'id'            => '用户主键',
        'status'        => '用户状态',
        'create_start'  => '创建起始时间',
        'create_end'    => '创建截止时间',
        'login_start'   => '登录起始时间',
        'login_end'     => '登录截止时间',
        'mobile'        => '手机号',
        'password'      => '密码',
        'confirm_pass'  => '确认密码',
    ];

    //验证场景
    protected $scene = [
        'entry' => ['id' => 'number', 'mobile'=> 'length:11|regex:mobile', 'page_size' => 'number', 'jump_page' => 'number', 'auditor' => 'number', 'status' => 'number', 'create_start' => 'date', 'create_end' => 'date', 'login_start' => 'date', 'login_end' => 'date'],
        'wait_auditor_entry' => ['id' => 'number', 'mobile'=> 'length:11|regex:mobile', 'page_size' => 'number', 'jump_page' => 'number','status' => 'number', 'create_start' => 'date', 'create_end' => 'date', 'login_start' => 'date', 'login_end' => 'date'],
        'create' => ['id' => 'number', 'mobile' => 'require|length:11|regex:mobile|unique:tb_user', 'password' => 'require|alphaDash|length:8,25', 'confirm_pass' => 'require|alphaDash|length:8,25|confirm:password'],
        'update' => ['id' => 'require|number','mobile' => 'regex:mobile|length:8', 'username' => 'max:255', 'status' => 'number', 'email' => 'email', 'company' => 'max:255', 'career' => 'max:255', 'occupation' => 'max:255'],
        'detail' => ['id' => 'require|number'],
        'delete' => ['id' => 'require|number'],
        'auditor'  => ['id' => 'require|array','type_id' => 'require|number|in:0,1','reason' => 'min:6'],
        'save'   => ['id' => 'number', 'company' => 'require|max:255', 'stage' => 'require|max:255', 'website' => 'url', 'industry' => 'max:255', 'legal_person' => 'require|max:255', 'duty' => 'max:255', 'mobile' => 'require|length:11|regex:mobile', 'phone' => 'max:255', 'email' => 'require|email', 'register_address' => 'require|max:255', 'business_license' => 'max:255', 'register_capital' => 'require|number', 'license_scan' => 'require', 'mailing_address' => 'max:255', 'sales_volume' => 'max:255', 'total_people' => 'number', 'developer_people' => 'number', 'patent' => 'max:255', 'high_technology' => 'require|number', 'service_direction'=> 'max:255', 'products_introduce' => 'min:300', 'business_introduce' => 'min:30', 'logo' => 'require'],
        'add'    => ['user_id' => 'require|number', 'group_id' => 'require|number'],
        'index'  => ['user_id' => 'number', 'group_id' => 'number', 'create_start' => 'date', 'create_end' => 'date', 'page_size' => 'number', 'jump_page' => 'number']
    ];
}