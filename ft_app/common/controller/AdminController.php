<?php
namespace app\common\controller;

/**
 * 继承此基类,表明需要管理员权限
 */

use app\index\logic\User;
use think\Session;
use app\common\controller\UserController;
class AdminController extends UserController
{
    public function _initialize()
    {
        parent::_initialize();
        $res = new User();
        if(!$res->IsAdmin())
        {
            $this->redirect('/index/user/myzone');
        }
    }


}
