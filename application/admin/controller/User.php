<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/15
 * Time: 14:32
 * Comment: 联盟成员控制器
 */

namespace app\admin\controller;

use app\admin\model\User as UserModel;
use app\admin\validate\User as UserValidate;
use think\Request;

class User extends BasisController {

    /**
     * 声明用户模型
     * @var
     */
    protected $user_model;

    /**
     * 声明用户验证器
     * @var
     */
    protected $user_validate;

    /**
     * 声明用户分页
     * @var
     */
    protected $user_page;

    /**
     * 默认构造函数
     * User constructor.
     * @param Request|null $request
     */
    public function __construct(Request $request = null) {
        parent::__construct($request);
        $this->user_model = new UserModel();
        $this->user_validate = new UserValidate();
        $this->user_page = config('pagination');
    }

    /**
     * 用户列表api接口
     */
    public function entry() {
        /* 接收客户端提供的参数 */
        $id = request()->param('id');
        $status = request()->param('status');
        $create_start = request()->param('create_start');
        $create_end = request()->param('create_end');
        $login_start = request()->param('login_start');
        $login_end = request()->param('login_end');
        $page_size = request()->param('page_size',$this->user_page['PAGE_SIZE']);
        $jump_page = request()->param('jump_page', $this->user_page['JUMP_PAGE']);

        //验证的数据
        $validate_data = [
            'page_size'     => $page_size,
            'jump_page'     => $jump_page,
            'id'            => $id,
            'status'        => $status,
            'create_start'  => $create_start,
            'create_end'    => $create_end,
            'login_start'   => $login_start,
            'login_end'     => $login_end
        ];

        //验证结果
        $result   = $this->user_validate->scene('user_list')->check($validate_data);
        if (!$result) {
            return json(['code' => '401', 'message' => $this->user_validate->getError()]);
        }

        $conditions = [];

        if ($id) {
            $conditions['id'] = $id;
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
            $conditions['create_time'] = ['between time',[$create_start, $create_end]];
        }

        if ($login_start && $login_end) {
            $conditions['login_time'] = ['between time',[$login_start, $login_end]];
        }

        $user = $this->user_model->where($conditions)
            ->paginate($page_size, false, ['page' => $jump_page]);
        return json([
            'code'      => '200',
            'message'   => '获取用户列表成功',
            'data'      => $user
        ]);
    }

    /**
     * 创建用户api接口
     */
    public function save() {
        $id = request()->param('id');
        $mobile = request()->param('mobile');
        $password = request()->param('password');
        $confirm_pass = request()->param('confirm_pass');
        $username = request()->param('username');
        $email = request()->param('email');
        $company = request()->param('company');
        $career = request()->param('career');
        $status = request()->param('status');
        $occupation = request()->param('occupation');

        $insert_validate_data = [
            'id'            => $id,
            'mobile'        => $mobile,
            'password'      => $password,
            'confirm_pass'  => $confirm_pass,
            'username'      => $username,
            'email'         => $email,
            'status'        => $status,
            'company'       => $company,
            'career'        => $career,
            'occupation'    => $occupation
        ];

        //如果是更新修改passwrod验证规则
        if (empty($id)){
            $result   = $this->user_validate->scene('save')->check($insert_validate_data);
            if (!$result) {
                return json(['code' => '401', 'message' => $this->user_validate->getError()]);
            }
        } else {
            $validate_data = [
                'id'            => $id,
                'username'      => $username,
                'email'         => $email,
                'company'       => $company,
                'career'        => $career,
                'status'        => $status,
                'occupation'    => $occupation
            ];
            $result   = $this->user_validate->scene('update')->check($validate_data);
            if (!$result) {
                return json(['code' => '401', 'message' => $this->user_validate->getError()]);
            }
        }

        $insert_data = [
            'username'      => $username,
            'email'         => $email,
            'company'       => $company,
            'career'        => $career,
            'status'        => $status,
            'occupation'    => $occupation,
        ];

        if (empty($id)){
            $data_add = [
                'register_time' => date('Y-m-d H:i:s'),
                'mobile'        => $mobile,
                'password'      => md5($password)
            ];
            $insert_data = array_merge($insert_data, $data_add);
        }else{
            if (!empty($password) && !empty($confirm_pass)){
                $insert_data = [
                    'username'      => $username,
                    'email'         => $email,
                    'company'       => $company,
                    'career'        => $career,
                    'occupation'    => $occupation,
                ];
            }
        }

        if (!empty($id)) {

            $update_result = $this->user_model->where('id','=', $id)->update($insert_data);

            if ($update_result) {
                return json([
                    'code'      => '200',
                    'message'   => '更新用户成功'
                ]);
            }else{
                return json([
                    'code'      => '404',
                    'message'   => '更新用户失败'
                ]);
            }
        } else {
            $insert_result = $this->user_model->insertGetId($insert_data);

            if ($insert_result) {
                return json([
                    'code'      => '200',
                    'message'   => '添加用户成功',
                    'id'        => $insert_result
                ]);
            }else{
                return json([
                    'code'      => '404',
                    'message'   => '添加用户失败'
                ]);
            }
        }

    }

    /**
     * 获取用户详情api接口
     */
    public function detail() {
        //获取前端提供的数据
        $id = request()->param('id');

        /* 验证 */
        $validate_data = [
            'id'        => $id
        ];

        $result   = $this->user_validate->scene('detail')->check($validate_data);
        if (!$result) {
            return json(['code' => '401', 'message' => $this->user_validate->getError()]);
        }

        $user = $this->user_model->where('id', '=', $id)->find();

        if ($user) {
            return json([
                'code'      => '200',
                'message'   => '获取用户成功',
                'data'      => $user
            ]);
        }
    }

    /**
     * 删除用户api接口
     */
    public function delete() {

        //获取前端提供的数据
        $id = request()->param('id');

        /* 验证 */
        $validate_data = [
            'id'        => $id
        ];

        //验证结果
        $result   = $this->user_validate->scene('delete')->check($validate_data);
        if (!$result) {
            return json(['code' => '401', 'message' => $this->user_validate->getError()]);
        }

        $delete_result =  $this->user_model->where('id', '=', $id)->delete();

        if ($delete_result) {
            return json([
                'code'      => '200',
                'message'   => '删除用户成功'
            ]);
        }else{
            return json([
                'code'      => '404',
                'message'   => '删除用户失败'
            ]);
        }
    }
}