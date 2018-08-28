<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/27
 * Time: 17:51
 * Comment: 分类模型
 */

namespace app\admin\model;

class Category extends BasisModel {

    /**
     * 自动写入时间
     * @var string
     */
    protected $autoWriteTimestamp = 'datetime';

    /**
     * 关联的数据表
     * @var string
     */
    protected $table = 'tb_category';
}