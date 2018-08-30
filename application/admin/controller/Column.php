<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/15
 * Time: 14:21
 * Comment: 栏目控制器
 */

namespace app\admin\controller;

use app\admin\model\Column as ColumnModel;
use app\admin\validate\Column as ColumnValidate;
use think\Request;

class Column extends BasisController {

    /**
     * 声明栏目模型
     * @var
     */
    protected $column_model;

    /**
     * 声明栏目验证器
     * @var
     */
    protected $column_validate;

    /**
     * 声明栏目分页器
     * @var
     */
    protected $column_page;

    /**
     * 默认构造函数
     * Column constructor.
     * @param Request|null $request
     */
    public function __construct(Request $request = null) {
        parent::__construct($request);
        $this->column_model = new ColumnModel();
        $this->column_validate = new ColumnValidate();
        $this->column_page = config('pagination');
    }

    /**
     * 栏目列表api接口
     */
    public function entry() {
        //获取客户端提交过来的数据
        $id = request()->param('id');
        $name = request()->param('name');
        $sort = request()->param('sort');
        $status = request()->param('status');
        $create_start = request()->param('create_start');
        $create_end = request()->param('create_end');
        $update_start = request()->param('update_start');
        $update_end = request()->param('update_end');
        $page_size = request()->param('page_size', $this->column_page['PAGE_SIZE']);
        $jump_page = request()->param('jump_page', $this->column_page['JUMP_PAGE']);

        //验证数据
        $validate_data = [
            'id'            => $id,
            'name'          => $name,
            'sort'          => $sort,
            'status'        => $status,
            'create_start'  => $create_start,
            'create_end'    => $create_end,
            'update_start'  => $update_start,
            'update_end'    => $update_end,
            'page_size'     => $page_size,
            'jump_page'     => $jump_page
        ];

        //验证结果
        $result = $this->column_validate->scene('entry')->check($validate_data);
        if (!$result) {
            return json([
                'code'      => '401',
                'message'   => $this->column_validate->getError()
            ]);
        }

        //筛选条件
        $conditions = [];
        if ($id) {
            $conditions['id'] = $id;
        }
        if ($name) {
            $conditions['name'] = ['like', '%' . $name . '%'];
        }
        if ($sort) {
            $conditions['sort'] = $sort;
        }
        if (is_null($status)) {
            $conditions['status'] = ['in',[0,1]];
        } else {
            switch ($status) {
                case 0:
                    $conditions['status'] = $status;
                    break;
                case 1:
                    $conditions['status'] = $status;
                    break;
                default:
                    break;
            }
        }
        if ($create_start && $create_end) {
            $conditions['create_time'] = ['between time', [$create_start, $create_end]];
        }
        if ($update_start && $update_end) {
            $conditions['update_time'] = ['between time', [$update_start, $update_end]];
        }

        //返回结果
        $column = $this->column_model->where($conditions)
            ->order('sort','desc')
            ->order('id', 'asc')
            ->paginate($page_size, false, ['page' => $jump_page]);

        if ($column) {
            return json([
                'code'      => '200',
                'message'   => '获取信息成功',
                'data'      => $column
            ]);
        } else {
            return json([
                'code'      => '404',
                'message'   => '获取信息失败'
            ]);
        }
    }

    /**
     * 栏目保存更新api接口
     */
    public function save() {

        //获取从客户端提交过来的数据
        $id = request()->param('id');
        $name = request()->param('name');
        $sort = request()->param('sort');
        $status = request()->param('status', 1);

        //验证数据
        $validate_data = [
            'id'        => $id,
            'name'      => $name,
            'sort'      => $sort,
            'status'    => $status
        ];

        //验证结果
        $result = $this->column_validate->scene('save')->check($validate_data);
        if (!$result) {
            return json([
                'code'      => '401',
                'message'   => $this->column_validate->getError()
            ]);
        }

        if (!empty($id)) {
            $manual_result = $this->column_model->save($validate_data, ['id' => $id]);
        } else {
            $manual_result = $this->column_model->save($validate_data);
        }
        //返回结果
        if ($manual_result) {
            return json([
                'code'      => '200',
                'message'   => '操作数据成功'
            ]);
        } else {
            return json([
                'code'      => '404',
                'message'   => '操作数据失败'
            ]);
        }
    }

    /**
     * 栏目详情api接口
     */
    public function detail() {

        //获取客户端提交过来的数据
        $id = request()->param('id');

        //验证数据
        $validate_data = [
            'id'        => $id
        ];

        //验证结果
        $result = $this->column_validate->scene('detail')->check($validate_data);
        if (!$result) {
            return json([
                'code'      => '401',
                'message'   => $this->column_validate->getError()
            ]);
        }

        //返回数据
        $column = $this->column_model->where('id', $id)->find();
        if ($column) {
            return json([
                'code'      => '200',
                'message'   => '获取信息成功',
                'data'      => $column
            ]);
        } else {
            return json([
                'code'      => '404',
                'message'   => '获取信息失败'
            ]);
        }
    }

    /**
     * 栏目删除api接口
     */
    public function delete() {
        //获取客户端提交过来的数据
        $id = request()->param('id');

        //验证数据
        $validate_data = [
            'id'        => $id
        ];

        //验证结果
        $result = $this->column_validate->scene('delete')->check($validate_data);
        if (!$result) {
            return json([
                'code'      => '401',
                'message'   => $this->column_validate->getError()
            ]);
        }

        //返回结果
        $manual_result = $this->column_model->where('id', $id)->delete();
        if ($manual_result) {
            return json([
                'code'      => '200',
                'message'   => '删除数据成功'
            ]);
        } else {
            return json([
                'code'      => '404',
                'message'   => '删除数据失败，数据不存在'
            ]);
        }
    }

}