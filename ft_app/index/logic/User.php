<?php
namespace app\index\logic;
use think\Model;
use think\Session;
class User extends Model{
    /* 登陆函数，调用此函数设置登陆信息 */
    public function LoginSetSession( $data ){
        Session::set('uname',$data['name']);
        Session::set('uid',$data['id']);
        Session::set('uhead_img',$data['head_img']);
    }

    /* 注销登陆函数，调用此函数注销登陆信息 */
    public function LogoutSetSession(){
        Session::clear();
    }

    /* 管理员信息登陆函数 */
    public function AdminLogin(){
        Session::set('uAdmin',true);
        return true;
    }

    /* 管理员信息注销函数 */
    public function AdminLogout(){
        if(Session::has('uAdmin')){
            Session::delete('uAdmin');
        }
        return true;
    }


    /* 网站主信息登陆函数 */
    public function HosterLogin(){
        Session::set('uHoster',true);
        return true;
    }

    /* 网站主信息注销函数 */
    public function HosterLogout(){
        if(Session::has('uHoster')){
            Session::delete('uHoster');
        }
        return true;
    }


    /* 判断用户是否已经登陆 */
    public function IsLogin(){
        if(Session::has('uname') && Session::has('uid') ){
            return true;
        }else{
            $this->LogoutSetSession();
            return false;
        }
    }

    /* 判断管理员是否已经登陆 */
    public function IsAdmin(){
        if( Session::has('uAdmin') && $this->IsLogin() ){
            if(Session::get('uAdmin') == true){
                return true;
            }else{
                $this->AdminLogout();
            }
        }
        return false;
    }

    /* 判断网站主是否已经登陆 */
    public function IsHoster(){
        if( Session::has('uHoster') && $this->IsAdmin() ){
            if(Session::get('uHoster') == true){
                return true;
            }else{
                $this->HosterLogout();
            }
        }
        return false;
    }


    /* 登陆验证函数，$data['email']:用户email  $data['passwd']:用户密码*/
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

    /* QQ登陆验证函数 */
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

    /* 当前用户密码验证函数 */
    public function VertifyPasswd( $passwd ) {
        $user = \think\Loader::model('User')::get(['id'=>Session::get('uid')]);
        if($user) {
            if($user['passwd'] == substr(md5($user['id'].$passwd),0,16))
            {
                return ['status'=>true, 'info'=>'密码正确'];
            }else{
                return ['status'=>false, 'info'=>'密码错误'];
            }
        }else{
            return ['status'=>false, 'info'=>'此用户不存在'];
        }
    }

    /* 修改当前用户密码函数 */
    public function updatePasswd( $passwd, $npasswd ) {
        $res = $this->VertifyPasswd($passwd);
        if($res['status']==false){
            return $res;
        }
        $user = \think\Loader::model('User')::get(['id'=>Session::get('uid')]);
        if(strlen($npasswd)>=6 && strlen($npasswd)<=18 )
        {
            $user->passwd = substr(md5($user['id'].$npasswd),0,16);

            $res = $user->save();
            if($res){
                return ['status'=>true, 'info'=>'密码修改成功'];
            }else{
                return ['status'=>false, 'info'=>'密码修改失败'];
            }

        }
        return ['status'=>false, 'info'=>'密码格式错误'];
    }

    /* 修改当前用户信息 */
    public function updateUserData( $passwd, $data ) {

        $res = $this->VertifyPasswd($passwd);
        if($res['status']==false){
            return $res;
        }
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
                return ['status'=>false, 'info'=>'用户信息修改失败'];
            }
        }
        return ['status'=>true, 'info'=>'用户信息修改成功'];

    }
    /* 验证当前用户是否是管理员，如果是则设置管理员信息 */
    public function VertifyAdmin( $passwd ){
        // TODO:此用户是否在管理员列表
        $user = \think\Loader::model('User')::get(['id'=>Session::get('uid')]);
        if($user) {
            if($user['passwd'] == substr(md5($user['id'].$passwd),0,16))
            {
                $this->AdminLogin();
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }




}