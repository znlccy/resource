<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/15
 * Time: 14:29
 * Comment: 动态验证器
 */

namespace app\admin\validate;

class Dynamic extends BasisValidate {

    //手机验证正则表达式
    protected $regex = [ 'mobile' => '/^(13[0-9]|14[579]|15[0-3,5-9]|16[6]|17[0135678]|18[0-9]|19[89])\d{8}$/'];

    //验证规则
    protected $rule = [
        'id'            => 'number',
        'column_id'     => 'number',
        'title'         => 'max:255',
        'description'   => 'max:255',
        'create_start'  => 'date',
        'create_end'    => 'date',
        'update_start'  => 'date',
        'update_end'    => 'date',
        'publish_start' => 'date',
        'publish_end'   => 'date',
        'recommend'     => 'number',
        'status'        => 'number',
        'publisher'     => 'length:11|regex:mobile',
        'page_size'     => 'number',
        'jump_page'     => 'number',
    ];

    //验证消息
    protected $message = [

    ];

    //验证字段
    protected $field = [
        'id'            => '动态主键',
        'column_id'     => '栏目主键',
        'title'         => '动态标题',
        'description'   => '动态简介',
        'create_start'  => '动态创建起始时间',
        'create_end'    => '动态创建截止时间',
        'update_start'  => '动态更新起始时间',
        'update_end'    => '动态更新截止时间',
        'publish_start' => '动态发布起始时间',
        'publish_end'   => '动态发布截止时间',
        'recommend'     => '动态推荐',
        'status'        => '动态状态',
        'page_size'     => '分页大小',
        'jump_page'     => '跳转页'
    ];

    //验证场景
    protected $scene = [
        'entry'         => ['id' => 'number', 'column_id' => 'number', 'title' => 'max:255', 'description' => 'max:255', 'create_start' => 'date', 'create_end' => 'date', 'update_start' => 'date', 'update_end' => 'date', 'publish_start' => 'date', 'publish_end' => 'date', 'recommend' => 'number', 'status' => 'number', 'publisher' => 'length:11|regex:mobile', 'page_size' => 'number', 'jump_page' => 'number'],
        'save'          => ['id' => 'number', 'column_id' => 'require|number', 'title' => 'require|max:255', 'description' => 'require|max:255', 'publish_time' => 'require|date', 'recommend' => 'require|number', 'status' => 'require|number'],
        'detail'        => ['id' => 'require|number'],
        'delete'        => ['id' => 'require|number']
    ];
}