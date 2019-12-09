<?php
namespace app\index\controller;

use app\common\controller\BaseController;
use think\Session;
use \think\File;
use think\Config;
use think\Validate;

class Notification extends BaseController
{
    public function Lists(){
        $notifications = \think\Loader::model('Notification')::where(['status'=>1])->field('id,title,status,create_time')->order('create_time','desc')->select();
        if(!$notifications){
            return $this->error("公告不存在");
        }
        $this->assign('notifications',$notifications);
        return $this->fetch("lists");
    }

    public function detial(){
        // 去掉非get请求
        if(!request()->isGet())
        {
            dump('error.');
            die;
        }

        $notification_id = input('id');
        $notification = \think\Loader::model('Notification')::get(['id'=>$notification_id]);
        if(!$notification){
            return $this->error("文章不存在");
        }

        $this->assign('notification',$notification);

        return $this->fetch("detial");
    }

    // 以下代码  需要添加登陆权限验证

    private  function LoginVerify(){
        if(!Session::has('uname'))
        {
            $this->error('您还没有登陆,请先登陆',url('/index/Login/index'));
            return false;
        }
        return true;
    }

    private  function AdminVerify(){
        $res = $this->LoginVerify();
        if(!$res){
            return ;
        }
        if(!Session::has('uAdmin'))
        {
            $this->error('Error:您没有权限访问此页.',url('/index/index'));
        }
    }

    public function noteLists(){
        $res = $this->AdminVerify();
        // 去掉非get请求
        if(!request()->isGet())
        {
            dump('error.');
            die;
        }
        $limit_num = input("limit");
        $article_num = \think\Loader::model('Notification')::count();
        $articles = \think\Loader::model('Notification')::order('status', 'desc')->order('create_time', 'desc')->paginate($limit_num);
        $data['code'] = 0;
        $data['msg'] = "top_msg";
        $data['count'] = $article_num;
        $data['data'] = $articles->toArray()['data'];
        return json($data);
    }

    public  function delete(){
        $res = $this->AdminVerify();
        // 去掉非post请求
        if(!request()->isPost())
        {
            dump('error.');
            die;
        }


        $id = input('id');
        if(empty($id)){
            $data = ['status'=>false,'info'=>"数据有误"];
            return json($data);
        }

        $cate = \think\Loader::model('Notification')::get(['id'=>$id]);
        if($cate['status']==1){
            $count = \think\Loader::model('Notification')::where(['status'=>1])->count();
            if($count<2){
                $data = ['status'=>false,'info'=>"不可以删除全部已发布的通知"];
                return json($data);
            }
        }

        $result = $cate->delete();
        if( $result ) {
            $data = ['status'=>true,'info'=>"success"];
            return json($data);
        }else{
            $data = ['status'=>false,'info'=>"删除失败"];
            return json($data);
        }

    }

    /* 草稿预览  使用article控制下的模板article  保证预览和发布效果一致 */
    public function previewDraft(){
        $res = $this->AdminVerify();
        // 去掉非get请求
        if(!request()->isGet())
        {
            dump('error.');
            die;
        }

        $notification_id = input('id');
        $notification = \think\Loader::model('Notification')::get(['id'=>$notification_id]);
        if(!$notification){
            return $this->error("文章不存在");
        }

        $this->assign('notification',$notification);

        return $this->fetch("detial");
    }

    public function add(){
        $res = $this->AdminVerify();
        // 去掉非get请求
        if(!request()->isGet())
        {
            dump('error.');
            die;
        }
        return $this->fetch("add");
    }

    public  function add_process(){
        $res = $this->AdminVerify();
        // 去掉非post请求
        if(!request()->isPost())
        {
            dump('error.');
            die;
        }
        $data=[
            'title' => input('title'),
            'content' => input('content')
        ];
        $data['status'] = 0;
        $cate = \think\Loader::model('Notification');
        $result = $cate->validate(true)->save($data);
        if($result === false) {
            $data = ['status'=>false,'info'=>$cate->getError()];
            return json($data);
        }

        $data = ['status'=>true,'info'=>"添加成功"];
        return json($data);
    }

    public function edit(){
        $res = $this->AdminVerify();
        // 去掉非get请求
        if(!request()->isGet())
        {
            dump('error.');
            die;
        }
        $notification_id = input('id');
        $notification = \think\Loader::model('Notification')::get(['id'=>$notification_id]);
        if(!$notification){
            return $this->error("文章不存在");
        }

        $this->assign('notification',$notification);

        return $this->fetch("edit");
    }
    public  function edit_process(){
        $res = $this->AdminVerify();
        // 去掉非post请求
        if(!request()->isPost())
        {
            dump('error.');
            die;
        }
        $id = input('id');
        $data=[
            'title' => input('title'),
            'content' => input('content')
        ];

        $cate = \think\Loader::model('Notification')::get($id);
        if(!$cate){
            return $this->error("通知不存在");
        }
        $validate = new Validate( [
            'title' => 'require|min:4|max:250',
            'content' => 'require|min:2'
        ]);
        if( !$validate->check($data))
        {
            $data = ['status'=>false,'info'=>$validate->getError()];
            return json($data);
        }
        $result = $cate->save($data);
        if($result === false) {
            $data = ['status'=>false,'info'=>$cate->getError()];
            return json($data);
        }

        $data = ['status'=>true,'info'=>"修改成功"];
        return json($data);
    }

    public function changesta(){
        $res = $this->AdminVerify();
        // 去掉非post请求
        if(!request()->isPost())
        {
            dump('error.');
            die;
        }
        $id = input('id');
        $data=[
            'status' => input('status')
        ];
        $cate = \think\Loader::model('Notification')::get($id);
        if(!$cate){
            return $this->error("通知不存在");
        }
        if($cate['status'] == $data['status']){
            $data = ['status'=>false,'info'=>"不需要修改"];
            return json($data);
        }
        if( $data['status'] == 0){
            $count = \think\Loader::model('Notification')::where(['status'=>1])->count();
            if($count<2){
                $data = ['status'=>false,'info'=>"不可以撤销所有已发布的通知"];
                return json($data);
            }
        }

        $result = $cate->save($data);
        if($result === false) {
            $data = ['status'=>false,'info'=>$cate->getError()];
            return json($data);
        }

        $data = ['status'=>true,'info'=>"修改成功"];
        return json($data);
    }

}