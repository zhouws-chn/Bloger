<?php
namespace app\index\logic;
use think\Model;
use think\Session;
class User extends Model{

    

    public function LoginVertify( $data ) {
        $user = \think\Loader::model('User')::get(['email'=>$data['email']]);

        if($user){
            if($user['passwd'] == substr(md5($user['id'].$data['passwd']),0,16))
            {
                Session::set('uname',$user['name']);
                Session::set('uid',$user['id']);
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

}