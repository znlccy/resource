<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/22
 * Time: 11:47
 * Comment: 图片上传接口
 */

namespace app\admin\controller;

use app\index\controller\BasicController;

class Image extends BasicController {

    public function upload(){

        $picture = request()->file('picture');

        if ($picture) {
            $info = $picture->move(ROOT_PATH . 'public' . DS . 'images');
            if ($info) {
                $sub_path     = str_replace('\\', '/', $info->getSaveName());
                $picture = '/images/' . $sub_path;
            }else{
                $data = ['code' => '404', 'message' => '图片上传错误'];
                return json($data);
            }
        }else{
            $data = ['code' => '404', 'message' => '图片上传错误'];
            return json($data);
        }

        $data = ['code' => '200', 'message' => '上传成功', 'data' => $picture];
        return json($data);
    }
}