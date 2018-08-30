<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/27
 * Time: 13:21
 * Comment: 明星项目验证器
 */

namespace app\admin\validate;

class Star extends  BasisValidate {

    //验证规则
    protected $rule = [
        'id'            => 'number',
        'name'          => 'max:255',
        'introduce'     => 'min:200',
        'create_start'  => 'date',
        'create_end'    => 'date',
        'update_start'  => 'date',
        'update_end'    => 'date',
        'sort'          => 'number',
        'status'        => 'number',
        'page_size'     => 'number',
        'jump_page'     => 'number'
    ];

    //验证消息
    protected $message = [

    ];

    //验证字段
    protected $field = [
        'id'            => '明星项目主键',
        'name'          => '明星项目名称',
        'introduce'     => '明星项目简介',
        'create_start'  => '明星项目创建起始时间',
        'create_end'    => '明星项目创建截止时间',
        'update_start'  => '明星项目更新起始时间',
        'update_end'    => '明星项目更新截止时间',
        'sort'          => '明星项目主键',
        'status'        => '明星项目状态',
        'page_size'     => '分页大小',
        'jump_page'     => '跳转页'
    ];

    //验证场景
    protected $scene = [
        'entry'         => ['id' => 'number', 'column_id' => 'number', 'title' => 'max:255', 'description' => 'max:255', 'create_start' => 'date', 'create_end' => 'date', 'update_start' => 'date', 'update_end' => 'date', 'publish_start' => 'date', 'publish_end' => 'date', 'recommend' => 'number', 'status' => 'number', 'publisher' => 'length:11|regex:mobile', 'page_size' => 'number', 'jump_page' => 'number'],
        'save'          => ['id' => 'number', 'name' => 'require|max:255', 'introduce' => 'require|min:200', 'picture' => 'require|image:180,80',  'sort' => 'require|number|min:1', 'status' => 'require|number'],
        'detail'        => ['id' => 'require|number'],
        'delete'        => ['id' => 'require|number']
    ];
}