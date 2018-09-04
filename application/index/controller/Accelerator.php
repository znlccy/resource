<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/27
 * Time: 14:09
 * Comment: 加速器控制器
 */

namespace app\index\controller;

use app\index\model\Accelerator as AcceleratorModel;
use app\index\validate\Accelerator as AcceleratorValidate;
use app\index\model\UserAccelerator as UserAcceleratorModel;
use app\index\model\Booster as BoosterModel;
use app\index\model\User  as UserModel;
use think\Controller;
use think\Request;
use think\Session;

class Accelerator extends Controller {

    /**
     * 声明加速器模型
     * @var
     */
    protected $accelerator_model;

    /**
     * 声明加速器申请模型
     * @var
     */
    protected $booster_model;

    /**
     * 声明用户加速器模型
     * @var
     */
    protected $user_accelerator_model;

    /**
     * 声明用户模型
     * @var
     */
    protected $user_model;

    /**
     * 声明加速器申请验证器
     * @var
     */
    protected $accelerator_validate;

    /**
     * 声明加速器分页器
     * @var
     */
    protected $accelerator_page;

    /**
     * 声明默认构造函数
     * Accelerator constructor.
     * @param Request|null $request
     */
    public function __construct(Request $request = null) {
        parent::__construct($request);
        $this->accelerator_model = new AcceleratorModel();
        $this->booster_model = new BoosterModel();
        $this->user_accelerator_model = new UserAcceleratorModel();
        $this->user_model = new UserModel();
        $this->accelerator_validate = new AcceleratorValidate();
        $this->accelerator_page = config('pagination');
    }

    /**
     * 加速器列表api接口
     * @return \think\response\Json
     * @throws \think\exception\DbException
     */
    public function index() {

        //获取客户端提交过来的数据
        $page_size = request()->param('page_size', $this->accelerator_page['PAGE_SIZE']);
        $jump_page = request()->param('jump_page', $this->accelerator_page['JUMP_PAGE']);

        //验证数据
        $validate_data = [
            'page_size'     => $page_size,
            'jump_page'     => $jump_page
        ];

        //验证结果
        $result = $this->accelerator_validate->scene('index')->check($validate_data);
        if (!$result) {
            return json([
                'code'      => '401',
                'message'   => $this->accelerator_validate->getError()
            ]);
        }

        //返回给客户端最新的数据
        $accelerator = $this->accelerator_model
            ->where('status = 1')
            ->order('id', 'desc')
            ->paginate($page_size, false, ['page' => $jump_page]);

        //返回给客户端数据
        if ($accelerator) {
            return json([
                'code'      => '200',
                'message'   => '获取加速器列表成功',
                'data'      => $accelerator
            ]);
        } else {
            return json([
                'code'      => '404',
                'message'   => '获取加速器列表失败'
            ]);
        }
    }

    /**
     * 获取加速器详情
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
            'id'       => $id
        ];

        //验证结果
        $result = $this->accelerator_validate->scene('detail')->check($validate_data);
        if (!$result) {
            return json([
                'code'      => '401',
                'message'   => $this->accelerator_validate->getError()
            ]);
        }

        //返回给客户端数据
        $accelerator = $this->accelerator_model->where('id', $id)->find();
        if ($accelerator) {
            return json([
                'code'      => '200',
                'message'   => '查询信息成功',
                'data'      => $accelerator
            ]);
        } else {
            return json([
                'code'      => '404',
                'message'   => '查询信息失败，数据库中不存在',
            ]);
        }
    }

    /**
     * 加速器申请api接口
     * @return \think\response\Json
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function apply() {

        //接收客户端提交过来的数据
        $accelerator_id = request()->param('accelerator_id');
        $name = request()->param('name');
        $mobile = request()->param('mobile');
        $company = request()->param('company');
        $industry = request()->param('industry');
        $duty = request()->param('duty');
        $email = request()->param('email');
        $status = 0;
        $apply_time = date('Y-m-d H:i:s', time());
        $reason = request()->param('reason');

        //验证数据
        $validate_data = [
            'accelerator_id' => $accelerator_id,
            'name'      => $name,
            'company'   => $company,
            'industry'  => $industry,
            'duty'      => $duty,
            'mobile'    => $mobile,
            'status'    => $status,
            'apply_time'=> $apply_time,
            'email'     => $email,
            'reason'    => $reason
        ];

        //验证结果
        $result = $this->accelerator_validate->scene('apply')->check($validate_data);
        if (!$result) {
            return json([
                'code'      => '401',
                'message'   => $this->accelerator_validate->getError()
            ]);
        }

        //判断用户是否已经登陆
        $client_token = request()->header('access-token');
        if (Session::has('access_token')){
            // 获取服务端存储的token
            $server_token = Session::get('access_token');
            if ($server_token != $client_token) {
                return json(['code' => '302', 'message' => '请先登录']);
            }
        }

        // 判断用户是否已报名
        $user_id = session('user.id');
        $result  = $this->user_accelerator_model
            ->where(['user_id' => $user_id, 'accelerator_id' => $accelerator_id])
            ->find();
        if ($result) {
            return json(['code' => '400', 'message' => '您已报名该加速器,无需重复提交']);
        }

        //获取加速器消息
        $accelerator_info = $this->accelerator_model
            ->where(['id' => $accelerator_id])
            ->find();

        //整理加速器状态
        $now_time = date('Y-m-d h:i:s', time());

        if ( $accelerator_info['limit'] != 0 ){
            if ( $accelerator_info['limit'] <= $accelerator_info['register'] ){
                return json(['code' => '400', 'message' => '申请人数已满']);
            }
        }

        if ( $accelerator_info['apply_time'] < $now_time ){
            return json(['code' => '400', 'message' => '加速器已结束']);
        }elseif ( $accelerator_info['begin_time'] > $now_time ){
            return json(['code' => '400', 'message' => '加速器申请未开始']);
        }elseif ( $accelerator_info['end_time'] < $now_time ){
            return json(['code' => '400', 'message' => '加速器申请已截止']);
        }

        //判断直接审核或者等待审核
        if ( $accelerator_info['audit_method'] == 1 ){
            $user_active_status = 1;
        }else{
            $user_active_status = 0;
        }

        $insert_data = ['user_id' => $user_id, 'accelerator_id' => $accelerator_id, 'apply_time' => $apply_time , 'register_time' => date("Y-m-d H:i:s", time()), 'status' => $user_active_status, 'reason' => $reason];

        $data = [ 'username' => $name, 'company' => $company, 'industry' => $industry, 'duty' => $duty, 'mobile' => $mobile, 'email' => $email];

        $update_result = $this->user_model->save($data, ['id' => $user_id]);
        $result = $this->user_accelerator_model->save($insert_data);
        if ($result) {
            // 活动人数+1
            $this->accelerator_model
                ->where(['id' => $accelerator_id])
                ->setInc('register');
            return json(['code' => '200', 'message' => '提交成功']);
        } else {
            return json(['code' => '404', 'message' => '报名失败']);
        }
    }
}