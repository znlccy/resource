<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/22
 * Time: 11:08
 * Comment: 空控制器
 */

namespace app\admin\controller;

use think\Controller;

class Error extends Controller {

    /**
     * 返回空操作
     */
    public function _empty() {
        return json([
            'code'      => '401',
            'message'   => '您操作不当，不存在当前控制器或方法'
        ]);
    }

}