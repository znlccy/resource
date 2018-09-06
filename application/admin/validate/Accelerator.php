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
        'id'            => '加速器主键',
        'name'          => '加速器名称',
        'description'   => '加速器简介',
        'picture'       => '加速器图片',
        'price'         => '加速器价格',
        'recommend'     => '加速器是否推荐',
        'status'        => '加速器状态',
        'address'       => '加速器地址',
        'create_start'  => '加速器创建起始时间',
        'create_end'    => '加速器创建截止时间',
        'update_start'  => '加速器更新起始时间',
        'update_end'    => '加速器更新截止时间',
        'publish_start' => '加速器发布起始时间',
        'publish_end'   => '加速器发布截止时间',
        'page_size'     => '分页大小',
        'jump_page'     => '跳转页'
    ];

    //验证场景
    protected $scene = [
        'entry'         => ['id' => 'number', 'name' => 'max:80', 'description' => 'max:255', 'picture' => 'max:255', 'price' => 'number', 'recommend' => 'number', 'status' => 'number', 'address' => 'max:255', 'create_start' => 'date', 'create_end' => 'date', 'update_start' => 'date', 'update_end' => 'date', 'publish_start' => 'date', 'publish_end' => 'date', 'page_size' => 'number', 'jump_page' => 'number'],
        'save'          => ['id' => 'number', 'name' => 'require|max:80', 'description' => 'require|max:255', 'picture' => 'require', 'price' => 'require', 'recommend' => 'number', 'address' => 'require|max:255', 'status' => 'require|number|in:0,1'],
        'detail'        => ['id' => 'require|number'],
        'delete'        => ['id' => 'require|number']
    ];
}