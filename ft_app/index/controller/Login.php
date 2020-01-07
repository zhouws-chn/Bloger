<?php
namespace app\index\controller;

use app\common\controller\BaseController;
use think\Session;
use think\Request;
use think\Validate;
use app\index\logic\User;
use loveteemo\qqconnect\QC;

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
    public function qqlogin()
    {
        // 去掉非get请求
        if(!request()->isGet())
        {
            dump('error.');
            die;
        }
        if(Session::has('uname'))
        {
            // 已经登陆 直接返回到首页
            return $this->error('已经登陆过了,不需要再次登陆');
        }
        $qc = new QC();
        return redirect($qc->qq_login());
    }

    public function connect()
    {
        // 去掉非get请求
        if(!request()->isGet())
        {
            dump('error.');
            die;
        }
        if(Session::has('uname'))
        {
            if(Session::has('bingqq_time')){
                if((time() - Session::get('bingqq_time'))<60*3){
                    $qc = new QC();
                    $access_token = $qc->qq_callback();    // access_token
                    $openid = $qc->get_openid();     // openid
                    $qc = new QC($access_token,$openid);
                    $qqUserInfo = $qc->get_user_info();
                    if (empty($openid) || empty($access_token) || count($qqUserInfo) <= 0) {
                        echo "获取用户信息异常,请重新尝试";
                        die;
                    }
                    $user = \app\index\model\User::get(Session::get('uid'));

                    $user->qqopenid = $openid;
                    $user->head_img = pic_download_from_url($qqUserInfo['figureurl_qq_2'],'users/images/');
                    $res = $user->save();
                    if($res){
                        Session::delete('bingqq_time');
                        return $this->success('绑定成功','/index/index');
                    }else{
                        return $this->error('绑定失败');
                    }
                }
            }
            // 已经登陆 直接返回到首页
            return $this->error('已经登陆过了,不需要再次登陆','/index/index');
        }

        $qc = new QC();
        $access_token = $qc->qq_callback();    // access_token
        $openid = $qc->get_openid();     // openid
        $qc = new QC($access_token,$openid);
        $qqUserInfo = $qc->get_user_info();
        if (empty($openid) || empty($access_token) || count($qqUserInfo) <= 0) {
            echo "获取用户信息异常,请重新尝试";
            die;
        }
        $user = new User();
        if( $user->QQLoginVertify($openid) )
        {
            return $this->success('登陆成功','/');
        }else{
            $data = ['status'=>false,'info'=>'这是一位新用户'];

        }
        return json($data);

    }

}
