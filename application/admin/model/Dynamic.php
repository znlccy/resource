<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/15
 * Time: 14:28
 * Comment: 动态模型
 */

namespace app\admin\model;

class Dynamic extends BasisModel {

    /**
     * 自动写入读取时间
     * @var string
     */
    protected $autoWriteTimestamp = 'datetime';

    /**
     * 关联的数据表
     * @var string
     */
    protected $table = 'tb_dynamic';

    /**
     * 设置富文本加密
     * @param $value
     * @return string
     */
    public function setRichtextAttr($value)
    {
        return htmlspecialchars($value);
    }

    /**
     * 获取富文本解密
     * @param $value
     * @return string
     */
    public function getRichtextAttr($value)
    {
        return htmlspecialchars_decode($value);
    }

    /**
     * 关联的数据表
     * @return array|\think\model\relation\HasOne
     */
    public function column() {
        return $this->hasOne('Column', 'id', 'column_id');
    }

}