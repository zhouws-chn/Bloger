<?php
namespace app\common\controller;

/**
 * 继承此基类,表明需要管理员权限
 */

use app\index\logic\User;
use think\Session;
use app\common\controller\AdminController;
class HostController extends AdminController
{
    public function _initialize()
    {
        parent::_initialize();
        /* TODO: 身份验证是否为网站主 */

    }


}
