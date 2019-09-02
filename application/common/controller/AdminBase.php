<?php
namespace app\common\controller;

use think\Session;
use app\common\controller\BaseController;
class AdminBase extends BaseController
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
