<?php
namespace app\index\controller;

use app\common\controller\BaseController;
use think\Session;
use \think\File;
use think\Config;

class Notification extends BaseController
{
    public function Lists(){
        $notifications = \think\Loader::model('Notification')::field('id,title,create_time')->order('create_time','desc')->select();
        if(!$notifications){
            return $this->error("公告不存在");
        }
        $this->assign('notifications',$notifications);
        return $this->fetch("lists");
    }

    public function detial(){
        // 去掉非get请求
        if(!request()->isGet())
        {
            dump('error.');
            die;
        }

        $notification_id = input('id');
        $notification = \think\Loader::model('Notification')::get(['id'=>$notification_id]);
        if(!$notification){
            return $this->error("文章不存在");
        }

        $this->assign('notification',$notification);

        return $this->fetch("detial");
    }

    // 以下代码  需要添加登陆权限验证

    private  function LoginVerify(){
        if(!Session::has('uname'))
        {
            $this->error('您还没有登陆,请先登陆',url('/index/Login/index'));
            return false;
        }
        return true;
    }

    private  function AdminVerify(){
        $res = $this->LoginVerify();
        if(!$res){
            return ;
        }
        if(!Session::has('uAdmin'))
        {
            $this->error('Error:您没有权限访问此页.',url('/index/index'));
        }
    }

}