<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/15
 * Time: 14:25
 * Comment: 栏目验证器
 */

namespace app\admin\validate;

class Column extends BasisValidate {

    //验证规则
    protected $rule = [
        'id'            => 'number',
        'name'          => 'max:120',
        'sort'          => 'number',
        'status'        => 'number',
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
        'id'            => '栏目主键',
        'name'          => '栏目名称',
        'sort'          => '栏目排序',
        'status'        => '栏目状态',
        'create_start'  => '栏目创建起始时间',
        'create_end'    => '栏目创建截止时间',
        'update_start'  => '栏目更新开始时间',
        'update_end'    => '栏目更新截止时间',
        'page_size'     => '分页大小',
        'jump_page'     => '跳转页'
    ];

    //验证场景
    protected $scene = [
        'entry'         => ['id' => 'number', 'name' => 'max:120', 'sort' => 'number', 'status' => 'number', 'create_start' => 'date', 'create_end' => 'date', 'update_start' => 'date', 'update_end' => 'date', 'page_size' => 'number', 'jump_page' => 'number'],
        'save'          => ['id' => 'number', 'name' => 'require|max:120', 'sort' => 'require|number', 'status' => 'require|number'],
        'detail'        => ['id' => 'require|number'],
        'delete'        => ['id' => 'require|number']
    ];
}