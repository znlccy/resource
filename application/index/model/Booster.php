<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/28
 * Time: 19:08
 * Coment: 入驻申请模型
 */

namespace app\index\model;

class Booster extends BasicModel {

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