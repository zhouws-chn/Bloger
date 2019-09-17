<?php
namespace app\index\controller;

use app\common\controller\BaseController;
use think\Session;
use think\Request;
use think\Validate;
use app\index\logic\User;
class Login extends BaseController
{
    // 请求登陆界面
    public function Index()
    {
        if(Session::has('uname'))
        {
            // 已经登陆 直接返回到首页
            return $this->error('已经登陆过了,不需要再次登陆');
        }
            
        return $this->fetch();
    }

    // 请求验证账号密码 Post信息
    public function Login()
    {
        // 去掉非post请求
        if(!request()->isPost())
        {
            dump('error.');
            die;
        }

        if(Session::has('uname'))
        {
            // 已经登陆 直接返回到首页
            $data = ['status'=>false,'info'=>'已经登陆过了,不需要再次登陆'];
            return json($data);
        }

        $validate = new Validate( [
            'email' => 'require|max:25|min:3',
            'passwd' => 'require|max:18|min:6',
            'verifyCode'  => 'require|length:4'
        ]);
        //连接数据库,判断密码的正确性
        $data=[
            'email' => input('email'),
            'passwd' => input('password'),
            'verifyCode' => input('verify_code')
        ];
        if( !$validate->check($data))
        {
            $data = ['status'=>false,'info'=>$validate->getError()];
            return json($data);
        }
        if(!captcha_check($data['verifyCode']))
        {
            $data = ['status'=>false,'info'=>'验证码不正确'];
            return json($data);
        }
        $user = new User();
        if( $user->LoginVertify($data) )
        {
            $data = ['status'=>true,'info'=>'登陆成功'];
            
        }else{
            $data = ['status'=>false,'info'=>'账户/密码有误'];
            
        }
        
        return json($data);

    }
    // 请求退出
    public function Logout()
    {
        if(Session::has('uname'))
        {
            
            Session::delete('uname');
            return $this->success('您已退出登陆','/');
        }
        return $this->error('您还没有登陆或已经成功退出','/');
    }
}
