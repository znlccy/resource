<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/28
 * Time: 18:45
 * Comment: 加速器申请模型
 */

namespace app\index\model;

class Admission extends BasicModel {

    /**
     * @var string
     */
    protected $autoWriteTimestamp = 'datetime';

    /**
     * @var string
     */
    protected $table = 'tb_admission';
}