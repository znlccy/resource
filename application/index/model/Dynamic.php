<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/29
 * Time: 10:18
 * Comment: 加速器动态模型
 */

namespace app\index\model;

class Dynamic extends BasicModel {

    /**
     * @var string
     */
    protected $autoWriteTimestamp = 'datetime';

    /**
     * @var string
     */
    protected $table = 'tb_dynamic';

}