<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/27
 * Time: 13:21
 * Comment: 明星项目控制器
 */

namespace app\index\controller;

use app\index\model\Star as StarModel;
use app\index\validate\Star as StarValidate;
use think\Request;

class Star extends BasicController {

    /**
     * 声明明星项目模型
     * @var
     */
    protected $star_model;

    /**
     * 声明明星项目验证器
     * @var
     */
    protected $star_validate;

    /**
     * 声明明星验证器
     * @var
     */
    protected $star_page;

    /**
     * 声明默认构造函数
     * Star constructor.
     * @param Request|null $request
     */
    public function __construct(Request $request = null) {
        parent::__construct($request);
        $this->star_model = new StarModel();
        $this->star_validate = new StarValidate();
        $this->star_page = config('pagination');
    }

    /**
     * 明星项目列表api接口
     * @return \think\response\Json
     * @throws \think\exception\DbException
     */
    public function index() {

        //接收客户端提交过来的数据
        $page_size = request()->param('page_size');
        $jump_page = request()->param('jump_page');

        //验证数据
        $validate_data = [
            'page_size'     => $page_size,
            'jump_page'     => $jump_page
        ];

        //验证结果
        $result = $this->star_validate->scene('index')->check($validate_data);
        if (!$result) {
            return json([
                'code'      => '401',
                'message'   => $this->star_validate->getError()
            ]);
        }

        //返回数据
        $star = $this->star_model
            ->where('status', '=', '1')
            ->order('id', 'desc')
            ->order('sort', 'desc')
            ->paginate($page_size, false, ['page' => $jump_page]);

        if ($star) {
            return json([
                'code'      => '200',
                'message'   => '获取明星项目成功',
                'data'      => $star
            ]);
        } else {
            return json([
                'code'      => '404',
                'message'   => '获取明星项目失败'
            ]);
        }
    }

}