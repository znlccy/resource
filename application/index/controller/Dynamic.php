<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/29
 * Time: 10:17
 * Comment: 加速器动态控制器
 */

namespace app\index\controller;

use app\index\model\Dynamic  as DynamicModel;
use app\index\validate\Dynamic as DynamicValidate;
use think\Request;

class Dynamic extends BasicControllerc {
    /**
     * 声明动态模型
     * @var
     */
    protected $dynamic_model;

    /**
     * 声明动态验证器
     * @var
     */
    protected $dynamic_validate;

    /**
     * 声明动态分页器
     * @var
     */
    protected $dynamic_page;

    /**
     * Dynamic constructor.
     * @param array $data
     */
    public function __construct(Request $request = null) {
        parent::__construct($request);
        $this->dynamic_model = new DynamicModel();
        $this->dynamic_validate = new DynamicValidate();
        $this->dynamic_page = config('pagination');
    }

    /**
     * 动态列表api接口
     * @return \think\response\Json
     * @throws \think\exception\DbException
     */
    public function index() {

        //获取客户端提交过来的参数
        $column_id = request()->param('column_id');
        $page_size = request()->param('page_size', $this->dynamic_page['PAGE_SIZE']);
        $jump_page = request()->param('jump_page', $this->dynamic_page['JUMP_PAGE']);

        //验证数据
        $validate_data = [
            'page_size'     => $page_size,
            'jump_page'     => $jump_page,
            'column_id'     => $column_id
        ];

        //验证结果
        $result = $this->dynamic_validate->scene('index')->check($validate_data);
        if (!$result) {
            return json([
                'code'      => '401',
                'message'   => $this->dynamic_validate->getError()
            ]);
        }

        //筛选条件
        $conditions = [];
        if ($column_id) {
            $conditions['column_id'] = $column_id;
        }

        //查询数据
        $dynamic = $this->dynamic_model
            ->alias('td')
            ->where($conditions)
            ->where('td.status = 1')
            ->order('td.id', 'desc')
            ->order('td.create_time', 'desc')
            ->join('tb_column tc', 'td.column_id = tc.id')
            ->field('td.id, td.title, td.picture, tc.name')
            ->paginate($page_size, false, ['page' => $jump_page]);

        //返回数据
        if ($dynamic) {
            return json([
                'code'      => '200',
                'message'   => '查询信息成功',
                'data'      => $dynamic
            ]);
        } else {
            return json([
                'code'      => '404',
                'message'   => '查询信息失败'
            ]);
        }
    }

    /**
     * 查询动态详情api接口
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function detail() {

        //接收客户端提交过来的数据
        $id = request()->param('id');

        //验证数据
        $validate_data = [
            'id'        => $id
        ];

        //验证结果
        $result = $this->dynamic_validate->scene('detail')->check($validate_data);
        if (!$result) {
            return json([
                'code'      => '401',
                'message'   => $this->dynamic_validate->getError()
            ]);
        }

        //返回数据
        $dynamic = $this->dynamic_model->where('id', $id)->find();
        if ($dynamic) {
            return json([
                'code'      => '200',
                'message'   => '查询信息成功',
                'data'      => $dynamic
            ]);
        } else {
            return json([
                'code'      => '404',
                'message'   => '查询信息失败'
            ]);
        }
    }
}