<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/27
 * Time: 13:21
 * Comment: 明星项目验证器
 */

namespace app\index\validate;

class Star extends BasicValidate {

    //验证规则
    protected $rule = [
        'page_size'     => 'number',
        'jump_page'     => 'number',
        'id'            => 'number'
    ];

    //验证消息
    protected $message = [

    ];

    //验证字段
    protected $field = [
        'page_size'     => '分页大小',
        'jump_page'     => '跳转页',
        'id'            => '明星项目主键'
    ];

    //验证场景
    protected $scene = [
        'index'     => ['page_size' => 'number', 'jump_page' => 'number'],
        'detail'    => ['id' => 'require|number'],
    ];
}