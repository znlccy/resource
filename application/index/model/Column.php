<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/15
 * Time: 14:22
 * Comment: 栏目模型
 */

namespace app\index\model;

class Column extends BasicModel {

    /**
     * 自动写入时间
     * @var string
     */
    protected $autoWriteTimestamp = 'datetime';

    /**
     * 关联的数据表
     * @var string
     */
    protected $table = 'tb_column';
}