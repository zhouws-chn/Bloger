<?php
namespace app\index\controller;

use app\common\controller\UserController;
use think\Session;
use think\Request;
use think\Validate;
use app\index\logic\User;
use loveteemo\qqconnect\QC;

class Logined extends UserController
{
    // 请求退出
    public function Logout()
    {
        $user = new User();
        $user->LogoutSetSession();
        return $this->success('注销登陆成功.','/');
    }
}
