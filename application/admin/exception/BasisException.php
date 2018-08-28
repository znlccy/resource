<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/27
 * Time: 15:08
 * Comment: 基础异常
 */

namespace app\admin\exception;

use think\Exception;
use Throwable;

class BasisException extends Exception {

    /**
     * 声明状态码
     * @var string
     */
    protected $code = '400';

    /**
     * 声明信息
     * @var string
     */
    protected $msg = '参数错误';

    /**
     * 声明返回的数据
     * @var int
     */
    protected $data = 999;

    /**
     * 声明是否跳转
     * @var bool
     */
    protected $should_to_client = true;

    /**
     * 声明默认构造函数
     * BasisException constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }

}
