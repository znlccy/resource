<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/16
 * Time: 9:12
 * Comment: 用户验证器
 */
namespace app\index\validate;

class User extends BasicValidate {

    //手机验证正则表达式
    protected $regex = [ 'mobile' => '/^(13[0-9]|14[579]|15[0-3,5-9]|16[6]|17[0135678]|18[0-9]|19[89])\d{8}$/'];

    //验证规则
    protected $rule = [
        'id'                => 'number',
        'mobile'            => 'regex:mobile|length:11',
        'password'          => 'length:8,25|alphaDash',
        'verify'            => 'captcha',
        'code'              => 'length:6|number',
        'confirm_pass'      => 'length:8,25|alphaDash|confirm:password',
        'encrypted_str'     => 'max:255',
        'username'          => 'length:2,25',
        'email'             => 'email',
        'company'           => 'max:255',
        'career'            => 'max:255',
        'occupation'        => 'max:255',
        'page_size'         => 'number',
        'jump_page'         => 'number',
        'old_password'      => 'length:8,25|alphaDash'
    ];

    //验证消息
    protected $message = [

    ];

    //验证领域
    protected $field = [
        'mobile'            => '用户手机账号',
        'password'          => '用户密码',
        'confirm_pass'      => '确认密码',
        'code'              => '短信验证码',
        'verify'            => '图形验证码',
        'encrypted_str'     => '加密字符串',
        'username'          => '姓名',
        'email'             => '用户邮箱',
        'company'           => '公司机构名称',
        'career'            => '职业',
        'occupation'        => '行业',
        'page_size'         => '分页大小',
        'jump_page'         => '跳转页',
        'id'                => '主键',
        'old_password'      => '原始密码'
    ];

    //验证场景
    protected $scene = [
        'login'             => ['mobile' => 'require|length:11|regex:mobile', 'password' => 'require|length:8,25|alphaDash', 'verify' => 'require|captcha'],
        'register'          => ['mobile' => 'require|length:11|regex:mobile', 'password' => 'require|length:8,25|alphaDash', 'verify' => 'require|captcha', 'code' => 'require|length:6|number'],
        'recover_pass'      => ['mobile' => 'require|length:11|regex:mobile', 'code' => 'require|length:6|number', 'verify' => 'require|captcha'],
        'change_pass'       => ['password' => 'require|length:8,25|alphaDash', 'confirm_pass' => 'require|length:8,25|alphaDash|confirm:password', 'encrypted_str' => 'require'],
        'modify_info'       => ['username' => 'require|length:2,25', 'email' => 'require|email', 'company' => 'require|max:255', 'career' => 'require|max:255', 'occupation' => 'require|max:255'],
        'apply'             => ['page_size' => 'number', 'jump_page' => 'number'],
        'cancel'            => ['id' => 'require|number'],
        'modify_pass'       => ['old_password'   => 'require|length:8,25|alphaDash', 'password' => 'require|length:8,25|alphaDash|confirm:confirm_pass', 'confirm_pass'   => 'require|length:8,25|alphaDash'],
        'notification'      => ['page_size' => 'number', 'jump_page' => 'number'],
        'notification_detail' => ['id' => 'require|number'],
        'save'   => ['id' => 'number', 'company' => 'require|max:255', 'stage' => 'require|max:255', 'website' => 'url', 'industry' => 'max:255', 'legal_person' => 'require|max:255', 'duty' => 'max:255', 'mobile' => 'require|length:11|regex:mobile', 'phone' => 'max:255', 'email' => 'require|email', 'register_address' => 'require|max:255', 'business_license' => 'max:255', 'register_capital' => 'require|number', 'license_scan' => 'require', 'mailing_address' => 'max:255', 'sales_volume' => 'max:255', 'total_people' => 'number', 'developer_people' => 'number', 'patent' => 'max:255', 'high_technology' => 'require|number', 'service_direction'=> 'max:255', 'products_introduce' => 'min:300', 'business_introduce' => 'min:30', 'logo' => 'require'],
    ];
}