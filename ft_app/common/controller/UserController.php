<?php
namespace app\common\controller;

/**
 * 继承此基类,表明需要用户登陆权限
 */

use think\Session;
use app\common\controller\BaseController;
class UserController extends BaseController
{
    public function _initialize()
    {
        parent::_initialize();
        if(!Session::has('uname'))
        {
            $this->error('您还没有登陆,请先登陆',url('/index/Login/index'));
        }
    }


}
