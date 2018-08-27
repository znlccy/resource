<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/15
 * Time: 14:37
 * Comment: 通知消息控制器
 */

namespace app\admin\controller;

use think\Request;
use app\admin\model\Information as InformationModle;
use app\admin\validate\Information as InformationValidate;

class Information extends BasisController {

    /**
     * 声明信息模型
     * @var
     */
    public $information_model;

    /**
     * 声明信息验证器
     * @var
     */
    public $information_validate;

    /**
     * 声明信息分页器
     * @var
     */
    public $information_page;

    /**
     * 默认构造函数
     * Information constructor.
     * @param Request|null $request
     */
    public function __construct(Request $request = null) {
        parent::__construct($request);
        $this->information_model = new InformationModle();
        $this->information_validate = new InformationValidate();
        $this->information_page = config('pagination');
    }

    /**
     * 消息列表api接口
     */
    public function entry() {

        //接收客户端提交过来的数据
        $id = request()->param('id');
        $status = request()->param('status');
        $title = request()->param('title');
        $publisher = request()->param('publisher');
        $create_start = request()->param('create_start');
        $create_end = request()->param('create_end');
        $update_start = request()->param('update_start');
        $update_end = request()->param('update_end');
        $publish_start = request()->param('publish_start');
        $publish_end = request()->param('publish_end');
        $page_size = request()->param('page_size', $this->information_page['PAGE_SIZE']);
        $jump_page = request()->param('jump_page', $this->information_page['JUMP_PAGE']);

        //验证数据
        $validate_data = [
            'id'            => $id,
            'status'        => $status,
            'title'         => $title,
            'publisher'     => $publisher,
            'create_start'  => $create_start,
            'create_end'    => $create_end,
            'update_start'  => $update_start,
            'update_end'    => $update_end,
            'publish_start' => $publish_start,
            'publish_end'   => $publish_end,
            'page_size'     => $page_size,
            'jump_page'     => $jump_page
        ];

        //验证结果
        $result = $this->information_validate->scene('entry')->check($validate_data);
        if (!$result) {
            return json([
                'code'      => '401',
                'message'   => $this->information_validate->getError()
            ]);
        }

        //筛选条件
        $conditions = [];
        if ($id) {
            $conditions['id'] = $id;
        }
        if ($status || $status === 0) {
            $conditions['status'] = $status;
        }
        if ($title) {
            $conditions['title'] = ['like', '%' . $title . '%'];
        }
        if ($publisher) {
            $conditions['publisher'] = ['like', '%' . $publisher . '%'];
        }
        if ($create_start && $create_end) {
            $conditions['create_time'] = ['between time', [$create_start, $create_end]];
        }
        if ($update_start && $update_end) {
            $conditions['update_time'] = ['between time', [$update_start, $update_end]];
        }
        $information = $this->information_model->where($conditions)
            ->where('status', '=', '1')
            ->paginate($page_size, false, ['page' => $jump_page]);
        if ($information) {
            return json([
                'code'      => '200',
                'message'   => '查询数据成功',
                'data'      => $information
            ]);
        } else {
            return json([
                'code'      => '200',
                'message'   => '查询数据失败'
            ]);
        }

    }

    /**
     * 消息保存更新api接口
     */
    public function save() {
        /* 获取前端提交的数据 */
        $id           = request()->param('id');
        $title        = request()->param('title');
        $publisher    = session('admin.id');
        $status       = request()->param('status');
        $publish_time = date('Y-m-d H:i:s', time());
        $rich_text    = request()->param('rich_text');

        /* 验证规则 */
        $validate_data = [
            'id'           => $id,
            'title'        => $title,
            'status'       => $status,
            'publisher'    => $publisher,
            'publish_time' => $publish_time,
            'rich_text'    => $rich_text
        ];

        //验证结果
        $result = $this->information_validate->scene('save')->check($validate_data);
        if (!$result) {
            return json(['code' => '401', 'message' => $this->information_validate->getError()]);
        }

        //返回数据
        if (!empty($id)) {
            /* 更新数据 */
            $result      = $this->information_model->save($validate_data, ['id' => $id]);
        } else {
            /* 保存数据 */
            $result      = $this->information_model->save($validate_data);
        }

        if ($result) {
            $data = ['code' => '200', 'message' => '保存成功!'];
            return json($data);
        } else {
            $data = ['code' => '404', 'message' => '保存失败!'];
            return json($data);
        }
    }

    /**
     * 消息详情api接口
     */
    public function detail() {
        //获取客户端提交的数据
        $id = request()->param('id');

        //验证数据
        $validate_data = [
            'id'            => $id
        ];

        //验证结果
        $result = $this->information_validate->scene('detail')->check($validate_data);
        if (!$result) {
            return json([
                'code'      => '401',
                'message'   => $this->information_validate->getError()
            ]);
        }

        //返回数据
        $service = $this->information_model->where('id', $id)->find();
        if ($service) {
            return json([
                'code'      => '200',
                'message'   => '查询数据成功',
                'data'      => $service
            ]);
        } else {
            return json([
                'code'      => '404',
                'message'   => '查询数据失败,数据不存在'
            ]);
        }
    }

    /**
     * 消息删除api接口
     */
    public function delete() {
        //获取客户端提交过来的数据
        $id = request()->param('id');

        //验证数据
        $validate_data = [
            'id'            => $id
        ];

        //验证结果
        $result = $this->information_validate->scene('delete')->check($validate_data);
        if (!$result) {
            return json([
                'code'      => '401',
                'message'   => $this->information_validate->getError()
            ]);
        }

        //返回结果
        $delete = $this->information_model->where('id', $id)->delete();
        if ($delete) {
            return json([
                'code'      => '200',
                'message'   => '删除数据成功'
            ]);
        } else {
            return json([
                'code'      => '401',
                'message'   => '删除数据失败'
            ]);
        }
    }
}
