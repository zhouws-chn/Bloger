<?php
namespace app\index\controller;

use app\common\controller\UserController;
use think\Session;
class User extends UserController
{
    public function myZone()
    {
        // 去掉非get请求
        if(!request()->isGet())
        {
            dump('error.');
            die;
        }
        if(Session::has('uAdmin'))
        {
            $this->redirect('Admin/myZone');
        }

        $user = \think\Loader::model('User')::get(['id'=>Session::get('uid')]);
        $this->assign('user',$user);
        return $this->fetch("my_zone");
    }

    public function updateUserData()
    {
        // 去掉非post请求
        if(!request()->isPost())
        {
            dump('error.');
            die;
        }
        $uname = input('name');
        $uemail = input('email');

        $passwd = input("oPassword");
        if(strlen($passwd)<6){
            $data = ['status'=>false,'info'=>'密码格式错误'];
            return json($data);
        }
        $npasswd = input("nPassword1");
        $npasswd2 = input("nPassword2");
        if(strlen($npasswd)!=0) {
            if ((strlen($npasswd)<6) || (strlen($npasswd)!=strlen($npasswd2)) || (strlen($npasswd)>18)) {
                $data = ['status'=>false,'info'=>'新密码格式错误'];
                return json($data);
            }
        }
        // 密码验证
        $logicUser = \think\Loader::model('User','logic');
        $vpRes = $logicUser->VertifyPasswd($passwd);
        if( !$vpRes ) {
            $data = ['status'=>false,'info'=>'密码错误'];
            return json($data);
        }

        // 更改密码
        if(strlen($npasswd)!=0){
            $upRes = $logicUser->updatePasswd($npasswd);
            if(!$upRes){
                $data = ['status'=>false,'info'=>'密码修改失败'];
                return json($data);
            }
        }
        $uData['name'] = $uname;
        $uData['email'] = $uemail;
        $uuRes = $logicUser->updateUserData($uData);

        if($uuRes){
            $data = ['status'=>true,'info'=>'资料修改成功'];
            return json($data);
        }else{
            $data = ['status'=>false,'info'=>'资料修改失败'];
            return json($data);
        }


    }

    // 验证管理员权限
    public function verifyAdmin(){
        // 去掉非post请求
        if(!request()->isPost())
        {
            dump('error.');
            die;
        }
        $password = input("password");
        if(empty($password)){
            dump('error.');
            die;
        }
        if(strlen($password)<6){
            dump('error.');
            die;
        }
        $logicUser = \think\Loader::model('User','logic');
        $vaRes = $logicUser->VertifyAdmin($password);
        if($vaRes){
            $data = ['status'=>true,'info'=>'权限验证成功'];
            return json($data);
        }else{
            $data = ['status'=>false,'info'=>'权限验证失败'];
            return json($data);
        }
    }
}
