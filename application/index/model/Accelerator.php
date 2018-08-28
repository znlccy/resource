<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/27
 * Time: 14:09
 * Comment: 加速器模型
 */

namespace app\index\model;

class Accelerator extends BasicModel {

    /**
     * 自动写入读取时间
     * @var string
     */
    protected $autoWriteTimestamp = 'datetime';

    /**
     * 关联的数据表
     * @var string
     */
    protected $table = 'tb_accelerator';

    /**
     * 编译富文本
     * @param $value
     * @return string
     */
    protected function setRichtextAttr($value) {
        return htmlspecialchars($value);
    }

    /**
     * 反编译富文本
     * @param $value
     * @return string
     */
    protected function getRichtextAttr($value) {
        return htmlspecialchars_decode($value);
    }

    /**
     * 关联的数据表
     * @return \think\model\relation\HasOne
     */
    public function category() {
        return $this->hasOne('Category', 'id', 'category_id');
    }

}