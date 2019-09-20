<?php
namespace app\common\controller;

use think\Controller;
use app\index\model\Cate;
class BaseController extends Controller
{

    public function _initialize()
    {
        $cates = Cate::field('id,name,priority')->order('priority','asc')->select();
        $this->assign('cates',$cates);
    }


}
