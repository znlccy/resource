<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/27
 * Time: 16:28
 * Comment: 项目入驻控制器
 */

namespace app\admin\controller;

use think\Request;

class Admission extends BasisController {

    /**
     * 声明入驻项目模型
     * @var
     */
    protected $admission_model;

    /**
     * 声明入驻项目验证器
     * @var
     */
    protected $admission_validate;

    /**
     * 声明
     * @var
     */
    protected $admission_page;

    public function __construct(Request $request = null) {
        parent::__construct($request);
    }

    public function entry() {

    }

    public function save() {

    }

    /**
     *
     * @return \think\response\Json
     */
    public function detail() {
        //获取客户端提交的数据
        $id = request()->param('id');

        //验证数据
        $validate_data = [
            'id'            => $id
        ];

        //验证结果
        $result = $this->star_validate->scene('detail')->check($validate_data);
        if (!$result) {
            return json([
                'code'      => '401',
                'message'   => $this->star_validate->getError()
            ]);
        }

        //返回数据
        $star = $this->star_model->where('id', $id)->find();
        if ($star) {
            return json([
                'code'      => '200',
                'message'   => '查询数据成功',
                'data'      => $star
            ]);
        } else {
            return json([
                'code'      => '404',
                'message'   => '查询数据失败,数据不存在'
            ]);
        }
    }

    public function delete() {
        //获取客户端提交过来的数据
        $id = request()->param('id');

        //验证数据
        $validate_data = [
            'id'            => $id
        ];

        //验证结果
        $result = $this->star_validate->scene('delete')->check($validate_data);
        if (!$result) {
            return json([
                'code'      => '401',
                'message'   => $this->star_validate->getError()
            ]);
        }

        //返回结果
        $delete = $this->star_model->where('id', $id)->delete();
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
     * 项目入驻审核api接口
     */
    public function auditor() {

    }

    /**
     * 项目入驻下载api接口
     */
    public function download() {

        //获取客户端提交过来的数据

    }

}