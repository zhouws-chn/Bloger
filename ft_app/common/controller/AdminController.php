<?php
namespace app\common\controller;

/**
 * 继承此基类,表明需要管理员权限
 */

use think\Session;
use app\common\controller\UserController;
class AdminController extends UserController
{
    public function _initialize()
    {
        parent::_initialize();
        if(!Session::has('uAdmin'))
        {
            $this->error('Error:您没有权限访问此页.',url('/index/index'));
        }
    }


}
