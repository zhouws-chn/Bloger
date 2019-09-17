<?php
namespace app\index\controller;

use app\common\controller\AdminBase;

class Cate extends AdminBase
{
    public function adminList(){
        return $this->fetch("adminlist");
    }
}
