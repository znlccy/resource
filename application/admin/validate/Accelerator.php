<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/27
 * Time: 14:09
 * Comment: 加速器验证器
 */

namespace app\admin\validate;

class Accelerator extends BasisValidate {

    //验证规则
    protected $rule = [
        'id'            => 'number',
        'name'          => 'max:80',
        'description'   => 'max:255',
        'picture'       => 'max:255',
        'category_id'   => 'number',
        'price'         => 'number',
        'recommend'     => 'number',
        'status'        => 'number',
        'address'       => 'max:255',
        'create_start'  => 'date',
        'create_end'    => 'date',
        'update_start'  => 'date',
        'update_end'    => 'date',
        'publish_start' => 'date',
        'publish_end'   => 'date',
        'page_size'     => 'number',
        'jump_page'     => 'number'
    ];

    //验证消息
    protected $message = [

    ];

    //验证字段
    protected $field = [
        'id'            => '服务主键',
        'name'          => '服务名称',
        'description'   => '服务简介',
        'picture'       => '服务图片',
        'category_id'   => '服务分类主键',
        'price'         => '服务价格',
        'recommend'     => '服务是否推荐',
        'status'        => '服务状态',
        'address'       => '服务地址',
        'create_start'  => '服务创建起始时间',
        'create_end'    => '服务创建截止时间',
        'update_start'  => '服务更新起始时间',
        'update_end'    => '服务更新截止时间',
        'publish_start' => '服务发布起始时间',
        'publish_end'   => '服务发布截止时间',
        'page_size'     => '分页大小',
        'jump_page'     => '跳转页'
    ];

    //验证场景
    protected $scene = [
        'entry'         => ['id' => 'number', 'name' => 'max:80', 'description' => 'max:255', 'picture' => 'max:255', 'category_id' => 'number', 'price' => 'number', 'recommend' => 'number', 'status' => 'number', 'address' => 'max:255', 'create_start' => 'date', 'create_end' => 'date', 'update_start' => 'date', 'update_end' => 'date', 'publish_start' => 'date', 'publish_end' => 'date', 'page_size' => 'number', 'jump_page' => 'number'],
        'save'          => ['id' => 'number', 'name' => 'require|max:80'],
        'detail'        => ['id' => 'require|number'],
        'delete'        => ['id' => 'require|number']
    ];
}