<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/29
 * Time: 17:29
 * Comment：用户报名加速器模型
 */

namespace app\index\model;

class UserAccelerator extends BasicModel {

    /**
     * 自动读取和写入时间
     * @var string
     */
    protected $autoWriteTimestamp = 'datetime';

    /**
     * 关联的数据库
     * @var string
     */
    protected $table = 'tb_user_accelerator';
}