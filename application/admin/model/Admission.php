<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/27
 * Time: 16:43
 * Comment: 入驻项目模型
 */

namespace app\admin\model;

class Admission extends BasisModel {

    /**
     * @var string
     */
    protected $autoWriteTimestamp = 'datetime';

    /**
     * @var string
     */
    protected $table = 'tb_admission';

}