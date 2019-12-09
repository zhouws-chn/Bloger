<?php
namespace app\index\controller;
use app\common\controller\BaseController;
use loveteemo\qqconnect\QC;
use think\Config;
use think\Session;

class Test extends BaseController
{
   public function index(){
       echo (ROOT_PATH);
   }

    public function test2(){
        $res = set_replace_str('__WEB_NAME__','测试系统');
       return $res;
    }

    public function test3(){
       $filename = TEMP_PATH.'..\\file_lock';
        $res =  file_exists($filename);
        if ($res == false){
            $file = fopen( $filename,'w');
            fclose($file);
        }
        $res = file_get_contents(TEMP_PATH.'..\\file_lock');


    }

    public function clear() {
        if (delete_dir_file(CACHE_PATH) || delete_dir_file(TEMP_PATH)) {
            $this->success('清除缓存成功');
        } else {
            $this->error('清除缓存失败');
        }
    }
}