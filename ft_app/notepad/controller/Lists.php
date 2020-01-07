<?php
namespace app\notepad\controller;

use app\common\controller\UserController;
class Lists extends UserController
{
    public function notes()
    {
        return $this->fetch('index');
    }

    public function tablelists(){
        // 去掉非get请求
        if(!request()->isGet())
        {
            dump('error.');
            die;
        }
        $limit_num = input("limit");
        $article_num = \think\Loader::model('Notepad')::count();
        $articles = \think\Loader::model('Notepad')::order('create_time', 'asc')->paginate($limit_num);
        $data['code'] = 0;
        $data['msg'] = "top_msg";
        $data['count'] = $article_num;
        $data['data'] = $articles->toArray()['data'];
        return json($data);
    }

    public function mindtablelists(){
        // 去掉非get请求
        if(!request()->isGet())
        {
            dump('error.');
            die;
        }
        $limit_num = input("limit");
        $article_num = \think\Loader::model('Mind')::count();
        $articles = \think\Loader::model('Mind')::order('create_time', 'asc')->paginate($limit_num);
        $data['code'] = 0;
        $data['msg'] = "top_msg";
        $data['count'] = $article_num;
        $data['data'] = $articles->toArray()['data'];
        return json($data);
    }

    public function minds()
    {
        return $this->fetch('minds');
    }
}
