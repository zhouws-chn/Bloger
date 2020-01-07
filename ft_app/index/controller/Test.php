<?php
namespace app\index\controller;
use app\common\controller\BaseController;
use loveteemo\qqconnect\QC;
use think\Config;
use think\Session;

class Test extends BaseController
{
   public function index(){
       echo (Session::get("bingqq_time"));
       echo ('<br/>');
       echo (time()-Session::get("bingqq_time"));
   }

    public function index2(){
        Session::set('bingqq_time',time());
    }

    public function index3(){
        $hh = pic_download_from_url("http://thirdqq.qlogo.cn/g?b=oidb&k=shQjxlo7Z9soXfPNbNbx1Q&s=100&t=1557270113",'users/images/');
        echo $hh;

    }

    public function index4(){
        if(Session::has('uAdmin')){
            $res =  Session::delete('uAdmin');
           dump($res);
        }
        else{
            return "1";
        }
    }


}