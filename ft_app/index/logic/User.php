<?php
namespace app\index\logic;
use think\Model;
use think\Session;
class User extends Model{

    public function LoginSetSession( $data ){
        Session::set('uname',$data['name']);
        Session::set('uid',$data['id']);
        Session::set('uhead_img',$data['head_img']);
    }

    public function LogoutSetSession(){
        Session::clear();
    }

    public function LoginVertify( $data ) {
        $user = \think\Loader::model('User')::get(['email'=>$data['email']]);

        if($user){
            if($user['passwd'] == substr(md5($user['id'].$data['passwd']),0,16))
            {
                $user->last_login_time = $user['this_login_time'];
                $user->this_login_time = time();
                $user->save();
                $this->LoginSetSession($user);
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public function QQLoginVertify( $openid ) {
        $user = \think\Loader::model('User')::get(['qqopenid'=>$openid]);

        if(isset($user)){
            $user->last_login_time = $user['this_login_time'];
            $user->this_login_time = time();
            $user->save();
            $this->LoginSetSession($user);
            return true;
        }else{
            return false;
        }
    }

    public function VertifyPasswd( $passwd ) {
        $user = \think\Loader::model('User')::get(['id'=>Session::get('uid')]);
        if($user) {
            if($user['passwd'] == substr(md5($user['id'].$passwd),0,16))
            {
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public function updatePasswd( $npasswd ) {
        $user = \think\Loader::model('User')::get(['id'=>Session::get('uid')]);
        if(strlen($npasswd)>=6 && strlen($npasswd)<=18 )
        {
            $user->passwd = substr(md5($user['id'].$npasswd),0,16);

            return $user->save();
        }
        return false;
    }

    public function updateUserData( $data ) {
        $user = \think\Loader::model('User')::get(['id'=>Session::get('uid')]);
        $uData = [];
        if(!empty($data['name'])){
            if($data['name']!=$user['name']){
                $uData['name'] = $data['name'];
            }
        }
        if(!empty($data['email'])){
            if($data['email']!=$user['email']){
                $uData['email'] = $data['email'];
            }
        }
        if(!empty($data['description'])){
            if($data['description']!=$user['description']){
                $uData['description'] = $data['description'];
            }
        }
        if(!empty($uData)){
            if( $user->save($uData)){
                $this->LoginSetSession($user);
            }else{
                return false;
            }
        }
        return true;

    }

    public function VertifyAdmin( $passwd ){
        // TODO:此用户是否在管理员列表
        $user = \think\Loader::model('User')::get(['id'=>Session::get('uid')]);
        if($user) {
            if($user['passwd'] == substr(md5($user['id'].$passwd),0,16))
            {
                Session::set('uAdmin',true);
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

}