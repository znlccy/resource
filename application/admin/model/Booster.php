<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/28
 * Time: 9:58
 * Comment: 加速器申请模型
 */

namespace app\admin\model;

class Booster extends BasisModel {

    /**
     * 自动写入读取时间
     * @var string
     */
    protected $autoWriteTimestamp = 'datetime';

    /**
     * 关联的数据表
     * @var string
     */
    protected $table = 'tb_booster';
}