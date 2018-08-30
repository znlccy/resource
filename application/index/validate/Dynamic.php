<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/29
 * Time: 10:19
 * Comment: 动态验证器
 */

namespace app\index\validate;

class Dynamic extends BasicValidate {

    //验证规则
    protected $rule = [
        'id'        => 'number',
        'column_id' => 'number',
        'page_size' => 'number',
        'jump_page' => 'number'
    ];

    //验证消息
    protected $message = [

    ];

    //验证字段
    protected $field = [
        'id'        => '动态主键',
        'column_id' => '分类主键',
        'page_size' => '分页大小',
        'jump_page' => '跳转页'
    ];

    //验证场景
    protected $scene = [
        'index'     => ['page_size' => 'number', 'jump_page' => 'number','column_id' => 'number'],
        'detail'    => ['id' => 'require|number']
    ];
}