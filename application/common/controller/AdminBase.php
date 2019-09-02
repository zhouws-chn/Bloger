<?php
namespace app\common\controller;

use think\Controller;
use think\Session;
use app\index\model\Cate;
class AdminBase extends Controller
{

    public function _initialize()
    {
        if(!Session::has('uname'))
        {
            $this->error('您还没有登陆,请先登陆',url('/index/Login/index'));
        }
        $cates = Cate::field('id,name')->order('priority','asc')->select();
        $this->assign('cates',$cates);
    }


}
