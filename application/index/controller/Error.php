<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/22
 * Time: 14:40
 * Comment: 空操作
 */

namespace app\index\controller;

use think\Controller;

class Error extends Controller {

    /**
     * 空控制器和空方法
     */
    public function _empty() {
        return json([
            'code'      => '401',
            'message'   => '您操作不当，不存在当前控制器或方法'
        ]);
    }
}