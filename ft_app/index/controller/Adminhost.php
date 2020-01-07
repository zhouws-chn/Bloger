<?php
namespace app\index\controller;

use app\common\controller\HostController;
use think\Session;
class Adminhost extends HostController {
    public function collect(){
        return $this->fetch("admin/system_host");
    }

    public function index(){
        return "此模块内测中....";
    }
}