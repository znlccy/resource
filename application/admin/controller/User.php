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
use app\admin\model\Group as GroupModel;
use app\admin\model\UserGroup as UserGroupModel;
use app\admin\validate\User as UserValidate;
use think\Request;

class User extends BasisController {

    /**
     * 声明用户模型
     * @var
     */
    protected $user_model;

    /**
     * 声明分组模型
     * @var
     */
    protected $group_model;

    /**
     * 声明用户组模型
     * @var
     */
    protected $user_group_model;

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
        $this->group_model = new GroupModel();
        $this->user_group_model = new UserGroupModel();
        $this->user_validate = new UserValidate();
        $this->user_page = config('pagination');
    }

    /**
     * 联盟成员添加和更新api接口
     */
    public function create() {

        //获取客户端提交过来的数据
        $id = request()->param('id');
        $mobile = request()->param('mobile');
        $password = request()->param('password');
        $confirm_pass = request()->param('confirm_pass');

        //验证数据
        $validate_data = [
            'id'            => $id,
            'mobile'        => $mobile,
            'password'      => $password,
            'confirm_pass'  => $confirm_pass
        ];

        //验证结果
        $result = $this->user_validate->scene('create')->check($validate_data);
        if (!$result) {
            return json([
                'code'      => '401',
                'message'   => $this->user_validate->getError()
            ]);
        }

        //插入数据
        $operator_data = [
            'id'            => $id,
            'mobile'        => $mobile,
            'password'      => md5($password)
        ];

        //返回数据
        if (empty($id)) {
            $operator_result = $this->user_model->save($operator_data);
        } else {
            $operator_result = $this->user_model->save($operator_data, ['id' => $id]);
        }
        if ($operator_result) {
            return json([
                'code'      => '200',
                'message'   => '数据操作成功'
            ]);
        }

    }

    /**
     * 成员列表api接口
     * @return \think\response\Json
     * @throws \think\exception\DbException
     */
    public function entry() {
        //接收客户端提交的数据
        $id = request()->param('id');
        $mobile = request()->param('mobile');
        $create_start = request()->param('create_start');
        $create_end = request()->param('create_end');
        $login_start = request()->param('login_start');
        $login_end = request()->param('login_end');
        $auditor = request()->param('auditor');
        $status = request()->param('status');
        $page_size = request()->param('page_size', $this->user_page['PAGE_SIZE']);
        $jump_page = request()->param('jump_page', $this->user_page['JUMP_PAGE']);

        //验证数据
        $validate_data = [
            'id'            => $id,
            'mobile'        => $mobile,
            'create_start'  => $create_start,
            'create_end'    => $create_end,
            'login_start'   => $login_start,
            'login_end'     => $login_end,
            'auditor'       => $auditor,
            'status'        => $status,
            'page_size'     => $page_size,
            'jump_page'     => $jump_page
        ];

        //验证结果
        $result = $this->user_validate->scene('entry')->check($validate_data);
        if (!$result) {
            return json([
                'code'      => '401',
                'message'   => $this->user_validate->getError()
            ]);
        }

        //筛选条件
        $conditions = [];
        if ($id) {
            $conditions['id'] = $id;
        }
        if ($mobile) {
            $conditions['mobile'] = $mobile;
        }
        if ($create_start && $create_end) {
            $conditions['create_time'] = ['between time', [$create_start, $create_end]];
        }
        if ($login_start && $login_end) {
            $conditions['update_time'] = ['between time', [$login_start, $login_end]];
        }
        if ($auditor || $auditor === 0) {
            $conditions['auditor'] = $auditor;
        }
        if ($status || $status === 0) {
            $conditions['status'] = $status;
        }

        //返回结果
        $user = $this->user_model->where($conditions)
            ->field('id, mobile, create_time, login_time, auditor, status')
            ->paginate($page_size, false, ['jump_page' => $jump_page]);

        if ($user) {
            return json([
                'code'      => '200',
                'message'   => '查询信息成功',
                'data'      => $user
            ]);
        } else {
            return json([
                'code'      => '404',
                'message'   => '查询信息失败'
            ]);
        }
    }

    /**
     *
     */
    public function wait_auditor_entry() {
        //接收客户端提交的数据
        $id = request()->param('id');
        $mobile = request()->param('mobile');
        $create_start = request()->param('create_start');
        $create_end = request()->param('create_end');
        $login_start = request()->param('login_start');
        $login_end = request()->param('login_end');
        $status = request()->param('status');
        $page_size = request()->param('page_size', $this->user_page['PAGE_SIZE']);
        $jump_page = request()->param('jump_page', $this->user_page['JUMP_PAGE']);

        //验证数据
        $validate_data = [
            'id'            => $id,
            'mobile'        => $mobile,
            'create_start'  => $create_start,
            'create_end'    => $create_end,
            'login_start'   => $login_start,
            'login_end'     => $login_end,
            'status'        => $status,
            'page_size'     => $page_size,
            'jump_page'     => $jump_page
        ];

        //验证结果
        $result = $this->user_validate->scene('entry')->check($validate_data);
        if (!$result) {
            return json([
                'code'      => '401',
                'message'   => $this->user_validate->getError()
            ]);
        }

        //筛选条件
        $conditions = [];
        if ($id) {
            $conditions['id'] = $id;
        }
        if ($mobile) {
            $conditions['mobile'] = $mobile;
        }
        if ($create_start && $create_end) {
            $conditions['create_time'] = ['between time', [$create_start, $create_end]];
        }
        if ($login_start && $login_end) {
            $conditions['update_time'] = ['between time', [$login_start, $login_end]];
        }
        $conditions['auditor'] = 1;
        if ($status || $status === 0) {
            $conditions['status'] = $status;
        }

        //返回结果
        $user = $this->user_model->where($conditions)
            ->field('id, mobile, create_time, login_time, auditor, status')
            ->paginate($page_size, false, ['jump_page' => $jump_page]);

        if ($user) {
            return json([
                'code'      => '200',
                'message'   => '查询信息成功',
                'data'      => $user
            ]);
        } else {
            return json([
                'code'      => '404',
                'message'   => '查询信息失败'
            ]);
        }
    }

    /**
     * 成员资料更新api接口
     * @return \think\response\Json
     */
    public function save() {
        //获取客户端提交的数据
        $id = request()->param('id');
        $company = request()->param('company');
        $stage = request()->param('stage');
        $website = request()->param('website');
        $industry = request()->param('industry');
        $legal_person = request()->param('legal_person');
        $duty = request()->param('duty');
        $mobile = request()->param('mobile');
        $phone = request()->param('phone');
        $email = request()->param('email');
        $register_address = request()->param('register_address');
        $business_license = request()->param('business_license');
        $register_capital = request()->param('register_capital');
        $license_scan = request()->file('license_scan');
        // 移动图片到框架应用根目录/public/images
        if ($license_scan) {
            $info = $license_scan->move(ROOT_PATH . 'public' . DS . 'images');
            if ($info) {
                /*echo '文件保存的名:' . $info->getFilename();*/
                $sub_path     = str_replace('\\', '/', $info->getSaveName());
                $license_scan = '/images/' . $sub_path;
            }
        }
        $mailing_address = request()->param('mailing_address');
        $sales_volume = request()->param('sales_volume');
        $total_people = request()->param('total_people');
        $developer_people = request()->param('developer_people');
        $patent = request()->param('patent');
        $high_technology = request()->param('high_technology');
        $service_direction = request()->param('service_direction');
        $products_introduce = request()->param('products_introduce');
        $business_introduce = request()->param('business_introduce');
        $logo = request()->file('logo');
        // 移动图片到框架应用根目录/public/images
        if ($logo) {
            $info = $logo->move(ROOT_PATH . 'public' . DS . 'images');
            if ($info) {
                /*echo '文件保存的名:' . $info->getFilename();*/
                $sub_path     = str_replace('\\', '/', $info->getSaveName());
                $logo = '/images/' . $sub_path;
            }
        }

        //验证数据
        $validate_data = [
            'id'                => $id,
            'company'           => $company,
            'stage'             => $stage,
            'website'           => $website,
            'industry'          => $industry,
            'legal_person'      => $legal_person,
            'duty'              => $duty,
            'mobile'            => $mobile,
            'phone'             => $phone,
            'email'             => $email,
            'register_address'  => $register_address,
            'business_license'  => $business_license,
            'register_capital'  => $register_capital,
            'license_scan'      => $license_scan,
            'mailing_address'   => $mailing_address,
            'sales_volume'      => $sales_volume,
            'total_people'      => $total_people,
            'developer_people'  => $developer_people,
            'patent'            => $patent,
            'high_technology'   => $high_technology,
            'service_direction' => $service_direction,
            'products_introduce'=> $products_introduce,
            'business_introduce'=> $business_introduce,
            'logo'              => $logo,
            'update_time'       => date('Y-m-d H:s:i', time()),
            'create_time'       => date('Y-m-d H:s:i', time())
        ];

        //验证结果
        $result = $this->user_validate->scene('apply')->check($validate_data);
        if (!$result) {
            return json([
                'code'      => '401',
                'message'   => $this->user_validate->getError()
            ]);
        }

        //返回数据
        $apply_result = $this->user_model->save($validate_data, ['id' => $id]);
        if ($apply_result) {
            return json([
                'code'      => '200',
                'message'   => '操作成功'
            ]);
        }
    }

    /**
     * 成员详情界面api接口
     */
    public function detail() {
        //获取客户端提交的数据
        $id = request()->param('id');

        //验证数据
        $validate_data = [
            'id'            => $id
        ];

        //验证结果
        $result = $this->user_validate->scene('detail')->check($validate_data);
        if (!$result) {
            return json([
                'code'      => '401',
                'message'   => $this->user_validate->getError()
            ]);
        }

        //返回数据
        $user = $this->user_model->where('id', $id)
            ->field('company, stage, website, industry, legal_person, duty, mobile, phone, email, register_address, business_license, register_capital, license_scan, mailing_address, sales_volume, total_people, developer_people, patent, high_technology, service_direction, products_introduce, business_introduce, logo')
            ->find();
        if ($user) {
            return json([
                'code'      => '200',
                'message'   => '查询数据成功',
                'data'      => $user
            ]);
        } else {
            return json([
                'code'      => '404',
                'message'   => '查询数据失败,数据不存在'
            ]);
        }
    }

    /**
     * 删除成员api接口
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
        $result = $this->user_validate->scene('delete')->check($validate_data);
        if (!$result) {
            return json([
                'code'      => '401',
                'message'   => $this->user_validate->getError()
            ]);
        }

        //返回结果
        $delete = $this->user_model->where('id', $id)->delete();
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
     * 审核通过api接口
     * @return \think\response\Json
     * @throws \think\exception\DbException
     */
    public function auditor() {
        //接收客户端提交过来的数据
        $id = request()->param('id/a');
        $type_id = intval(request()->param('type_id'));
        $reason = request()->param('reason');

        //验证数据
        $validate_data = [
            'id'        => $id,
            'type_id'   => $type_id,
            'reason'    => $reason
        ];

        //验证结果
        $result = $this->user_validate->scene('auditor')->check($validate_data);
        if (!$result) {
            return json([
                'code'      => '401',
                'message'   => $this->user_validate->getError()
            ]);
        }

        //更新数据
        $operator_result = false;
        //发送通知
        $list = UserModel::all($id);
        switch ($type_id) {
            case 0:
                for($i=0; $i< count($id); $i++) {
                    $data['id'] = (int)$id[$i];
                    $data['auditor'] = 0;
                    $operator_result = $this->user_model->update($data);
                }
                //发送短信提醒
                foreach ($list as $key => $user) {
                    send_fail_code($user->mobile,$reason);
                }
                //添加短信提醒
                if ($operator_result) {
                    return json([
                        'code'      => '200',
                        'message'   => '拒绝成功'
                    ]);
                }
                break;
            case 1:
                for($i=0; $i< count($id); $i++) {
                    $data['id'] = (int)$id[$i];
                    $data['auditor'] = 2;
                    $operator_result = $this->user_model->update($data);
                }
                //发送通知
                foreach ($list as $key => $user) {
                    send_success_code($user->mobile);
                }
                //添加短信提醒
                if ($operator_result) {
                    return json([
                        'code'      => '200',
                        'message'   => '授权成功'
                    ]);
                }
        }
    }

    /**
     * 获取下拉成员api接口
     */
    public function company_spinner() {

        //查询数据
        $company = $this->user_model->where('auditor = 2')->field('id,company')->select();

        //返回数据
        if ($company) {
            return json([
                'code'      => '200',
                'message'   => '获取公司下拉列表成功',
                'company'   => $company
            ]);
        }
    }

    /**
     * 获取下拉成员分组api接口
     */
    public function group_spinner() {

        //查询数据
        $group = $this->group_model->order('sort', 'desc')
            ->order('id', 'asc')
            ->field('id, name')
            ->select();

        //返回数据
        if ($group) {
            return json([
                'code'      => '200',
                'message'   => '获取分组下拉列表成功',
                'group'   => $group
            ]);
        }
    }

    /**
     * 联盟成员添加api接口
     */
    public function add() {

        //获取客户端提交的数据
        $user_id = request()->param('user_id');
        $group_id = request()->param('group_id');

        //验证数据
        $validate_data = [
            'user_id'           => $user_id,
            'group_id'          => $group_id
        ];

        //验证结果
        $result = $this->user_validate->scene('add')->check($validate_data);
        if (!$result) {
            return json([
                'code'      => '401',
                'message'   => $this->user_validate->getError()
            ]);
        }

        $user = $this->user_group_model->where('user_id', $user_id)->find();
        if ($user) {
            return json([
                'code'      => '401',
                'message'   => '一个用户只能属于一个分组，一个分组可以有多个用户'
            ]);
        } else {
            $operator_result = $this->user_group_model->save($validate_data);
            if ($operator_result) {
                return json([
                    'code'      => '200',
                    'message'   => '添加数据成功'
                ]);
            } else {
                return json([
                    'code'      => '401',
                    'message'   => '添加数据失败'
                ]);
            }
        }
    }

    /**
     * 联盟成员展示api接口
     * @return \think\response\Json
     * @throws \think\exception\DbException
     */
    public function index() {

        //接收客户端提供的数据
        $user_id = request()->param('user_id');
        $group_id = request()->param('group_id');
        $create_start = request()->param('create_start');
        $create_end = request()->param('create_end');
        $page_size = request()->param('page_size', $this->user_page['PAGE_SIZE']);
        $jump_page = request()->param('jump_page', $this->user_page['JUMP_PAGE']);

        //验证数据
        $validate_data = [
            'user_id'       => $user_id,
            'group_id'      => $group_id,
            'create_start'  => $create_start,
            'create_end'    => $create_end,
            'page_size'     => $page_size,
            'jump_page'     => $jump_page
        ];

        //验证结果
        $result = $this->user_validate->scene('index')->check($validate_data);
        if (!$result) {
            return json([
                'code'      => '401',
                'message'   => $this->user_validate->getError()
            ]);
        }

        //筛选条件
        $conditions = [];
        if ($user_id) {
            $conditions['user_id'] = $user_id;
        }
        if ($group_id) {
            $conditions['group_id'] = $group_id;
        }
        if ($create_start && $create_end) {
            $conditions['create_time'] = ['between time', [$create_start, $create_end]];
        }
        $data = $this->user_group_model
            ->alias('gm')
            ->where($conditions)
            ->join('tb_user tu', 'tu.id = gm.user_id')
            ->join('tb_group tg', 'tg.id = gm.group_id')
            ->field('tu.company, tg.name, gm.create_time')
            ->paginate($page_size, false, ['page' => $jump_page]);

        return json([
            'code'      => '200',
            'message'   => '获取信息成功',
            'data'      => $data
        ]);
    }
}