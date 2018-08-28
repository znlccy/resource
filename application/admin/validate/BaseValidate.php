<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/23
 * Time: 15:22
 * Comment: 基础验证器
 */

namespace app\admin\validate;

use think\Exception;
use think\Request;
use think\Validate;

class BaseValidate extends Validate {

    /**
     * 参数验证
     * @return bool
     * @throws Exception
     */
    public function goCheck(){
        //获取http传入的参数
        // 对这些参数做校验
        $request = Request::instance();
        $params = $request->param();

        $result = $this->check($params);
        if (!$result){
            $error = $this->error;
            throw new Exception($error);
        }else{
            return true;
        }
    }
}