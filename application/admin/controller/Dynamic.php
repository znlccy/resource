<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/15
 * Time: 14:28
 * Comment: 动态控制器
 */

namespace app\admin\controller;

use app\admin\model\Dynamic as DynamicModel;
use app\admin\model\Column as ColumnModel;
use app\admin\validate\Dynamic as DynamicValidate;
use think\Request;
use think\Session;

class Dynamic extends BasisController {

    /**
     * 声明动态模型
     * @var
     */
    protected $dynamic_model;

    /**
     * 声明栏目模型
     * @var
     */
    protected $column_model;

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
     * 默认构造函数
     * Dynamic constructor.
     * @param Request|null $request
     */
    public function __construct(Request $request = null) {
        parent::__construct($request);
        $this->dynamic_model = new DynamicModel();
        $this->column_model = new ColumnModel();
        $this->dynamic_validate = new DynamicValidate();
        $this->dynamic_page = config('pagination');
    }

    /**
     * 获取动态列表api接口
     */
    public function entry() {
        //获取客户端提交过来的数据
        $id = request()->param('id');
        $column_id = request()->param('column_id');
        $title = request()->param('title');
        $description = request()->param('description');
        $create_start = request()->param('create_start');
        $create_end = request()->param('create_end');
        $update_start = request()->param('update_start');
        $update_end = request()->param('update_end');
        $publish_start = request()->param('publish_start');
        $publish_end = request()->param('publish_end');
        $recommend = request()->param('recommend');
        $status = request()->param('status');
        $publisher = request()->param('publisher');
        $page_size = request()->param('page_size', $this->dynamic_page['PAGE_SIZE']);
        $jump_page = request()->param('jump_page', $this->dynamic_page['JUMP_PAGE']);

        //验证数据
        $validate_data = [
            'id'            => $id,
            'column_id'     => $column_id,
            'title'         => $title,
            'description'   => $description,
            'create_start'  => $create_start,
            'create_end'    => $create_end,
            'update_start'  => $update_start,
            'update_end'    => $update_end,
            'publish_start' => $publish_start,
            'publish_end'   => $publish_end,
            'recommend'     => $recommend,
            'status'        => $status,
            'publisher'     => $publisher,
            'page_size'     => $page_size,
            'jump_page'     => $jump_page
        ];

        //验证结果
        $result = $this->dynamic_validate->scene('entry')->check($validate_data);
        if (!$result) {
            return json([
                'code'      => '401',
                'message'   => $this->dynamic_validate->getError()
            ]);
        }

        //条件筛选
        $conditions = [];

        if ($id) {
            $conditions['id'] = $id;
        }
        if ($column_id) {
            $conditions['column_id'] = $column_id;
        }
        if ($title) {
            $conditions['title'] = ['like', '%' . $title . '%'];
        }
        if ($description) {
            $conditions['description'] = ['like', '%' . $description . '%'];
        }
        if ($create_start && $create_end) {
            $conditions['create_time'] = ['between time', [$create_start, $create_end]];
        }
        if ($update_start && $update_end) {
            $conditions['update_time'] = ['between time', [$update_start, $update_end]];
        }
        if ($publish_start && $publish_end) {
            $conditions['publish_time'] = ['between time', [$publish_start, $publish_end]];
        }
        if ($recommend || $recommend === 0) {
            $conditions['recommend'] = $recommend;
        }
        if ($status || $status === 0) {
            $conditions['status'] = $status;
        }
        if ($publisher) {
            $conditions['publisher'] = $publisher;
        }

        //返回数据
        $dynamic = $this->dynamic_model->where($conditions)
            ->with(['column' => function ($query) {
                $query->withField("id, name");
            }])
            ->order('id', 'desc')
            ->paginate($page_size, false, ['page' => $jump_page])->each(function ($item, $key) {
                unset($item['category_id']);
                return $item;
            });

        return json([
            'code'      => '200',
            'message'   => '获取动态列表成功',
            'data'      => $dynamic
        ]);
    }

    /**
     * 动态列表添加更新api接口
     * @return \think\response\Json
     */
    public function save() {
        /* 获取前端提交的数据 */
        $id           = request()->param('id');
        $title        = request()->param('title');
        $description  = request()->param('description');
        $picture      = request()->file('picture');
        $column_id    = request()->param('column_id');
        $recommend    = request()->param('recommend', 0);
        $publish_time = date('Y-m-d H:i:s', time());
        $status       = request()->param('status', 0);
        $rich_text    = request()->param('rich_text');
        $admin        = Session::get('admin');
        $publisher    = $admin['mobile'];

        // 移动图片到框架应用根目录/public/images
        if ($picture) {
            $info = $picture->move(ROOT_PATH . 'public' . DS . 'images');
            if ($info) {
                //成功上传后，获取上传信息
                //输出文件保存路径
                $sub_path = str_replace('\\', '/', $info->getSaveName());
                $picture  = '/images/' . $sub_path;
            }
        }

        //验证数据
        $validate_data = [
            'id'            => $id,
            'title'         => $title,
            'description'   => $description,
            'picture'       => $picture,
            'column_id'     => $column_id,
            'recommend'     => $recommend,
            'publish_time'  => $publish_time,
            'status'        => $status,
            'publisher'     => $publisher,
            'rich_text'     => $rich_text
        ];

        //验证结果
        $result = $this->dynamic_validate->scene('save')->check($validate_data);
        if (!$result) {
            return json([
                'code'      => '401',
                'message'   => $this->dynamic_validate->getError()
            ]);
        }
        if (empty($id)) {
            $result  = $this->dynamic_model->save($validate_data);
        } else {
            if (empty($picture)) {
                unset($validate_data['picture']);
            }
            $result  = $this->dynamic_model->save($validate_data, ['id' => $id]);
        }
        if ($result) {
            $data = ['code' => '200', 'message' => '保存成功!'];
            return json($data);
        } else {
            $data = ['code' => '404', 'message' => '保存失败'];
            return json($data);
        }
    }

    /**
     * 动态详情api接口
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function detail() {
        //获取客户端提交的数据
        $id = request()->param('id');

        //验证数据
        $validate_data = [
            'id'            => $id
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
        $service = $this->dynamic_model->where('id', $id)->find();
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
     * 动态删除api接口
     * @return \think\response\Json
     */
    public function delete() {

        //获取客户端提交过来的数据
        $id = request()->param('id');

        //验证数据
        $validate_data = [
            'id'            => $id
        ];

        //验证结果
        $result = $this->dynamic_validate->scene('delete')->check($validate_data);
        if (!$result) {
            return json([
                'code'      => '401',
                'message'   => $this->dynamic_validate->getError()
            ]);
        }

        //返回结果
        $delete = $this->dynamic_model->where('id', $id)->delete();
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

    /**
     * 获取栏目下拉列表
     */
    public function spinner() {
        //获取数据
        $column = $this->column_model->where('status','1')->field('id,name')->select();

        if ($column) {
            return json([
                'code'      => '200',
                'message'   => '获取栏目列表成功',
                'data'      => $column
            ]);
        } else {
            return json([
                'code'      => '404',
                'message'   => '获取栏目列表失败'
            ]);
        }
    }

    /**
     * 获取富文本中第一张图片
     */
    protected function get_rich_image() {
        /* 获取的时候通过php的htmlspecialchars_decode()函数将信息里的 &lt;内容转换成html的标记，再通过strip_tags()将html标记去除就可以获取到干净的内容了 */
        $this->dynamic_model->getRichtextAttr();
    }
}