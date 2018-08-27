<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/27
 * Time: 13:20
 * Comment: 明星项目控制器
 */

namespace app\admin\controller;

use think\Request;

class Star extends BasisController {

    /**
     * 声明明星模型
     * @var
     */
    protected $star_model;

    /**
     * 声明明星验证器
     * @var
     */
    protected $start_validate;

    /**
     * @var
     */
    protected $star_page;

    /**
     * Star constructor.
     * @param Request|null $request
     */
    public function __construct(Request $request = null) {
        parent::__construct($request);
    }

    public function entry() {

    }

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

    public function detail() {

    }

    public function delete() {

    }
}