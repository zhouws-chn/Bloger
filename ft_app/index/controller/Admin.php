<?php
namespace app\index\controller;

use app\common\controller\AdminController;
use think\Session;
class Admin extends AdminController
{
    public function myZone()
    {
        // 去掉非get请求
        if(!request()->isGet())
        {
            dump('error.');
            die;
        }

        $user = \think\Loader::model('User')::get(['id'=>Session::get('uid')]);
        $this->assign('user',$user);
        return $this->fetch("my_zone");
    }
}
