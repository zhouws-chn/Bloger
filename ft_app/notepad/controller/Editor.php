<?php
namespace app\notepad\controller;

use app\common\controller\BaseController;
use app\common\controller\UserController;
use app\notepad\model\Notepad;

class Editor extends UserController
{
    public function preview()
    {
        $id = input('id');
        $article = \think\Loader::model('Notepad')::get(['id'=>$id]);
        if(!$article){
            return $this->error("文章不存在");
        }
        $this->assign('article',$article);
        return $this->fetch('preview');
    }
    public function index()
    {
        return $this->fetch('index');
    }
    public function update()
    {
        // 去掉非post请求
        if(request()->isGet())
        {
            return $this->fetch('update');
        }else if(request()->isPost())
        {
            $id = input('id');
            $notepad = \think\Loader::model('Notepad')::get(['id'=>$id]);
            $data = ['status'=>true,'info'=>'保存成功','id'=>$notepad->id,'title'=>$notepad->title,'content'=>$notepad->content ];
            return json($data);
        }

    }
    public function delete()
    {
        if(request()->isPost())
        {
            $id = input('id');
            $notepad = \think\Loader::model('Notepad')::get(['id'=>$id]);
            $notepad->delete();
            $data = ['status'=>true,'info'=>'保存成功','id'=>$notepad->id ];
            return json($data);
        }
    }

    public function save(){
        // 去掉非post请求
        if(!request()->isPost())
        {
            dump('error.');
            die;
        }
        $data=[
            'title' => input('title'),
            'content' => input('content'),
            'id' => input('id')
        ];
        if($data['id'] == 0){
            $notepad = new Notepad();
            unset($data['id']);
            $res = $notepad->save($data);
            if($res){
                $data = ['status'=>true,'info'=>'保存成功','id'=>$notepad->id ];
                return json($data);
            }else{
                $data = ['status'=>false,'info'=>'保存失败' ];
                return json($data);
            }

        }else{
            $notepad = \think\Loader::model('Notepad')::get(['id'=>$data['id']]);
            if($notepad->title != $data['title'])
                $notepad->title = $data['title'];
            if($notepad->title != $data['content'])
                $notepad->content = $data['content'];
            unset( $data['id']);
            if(empty($data)){
                $data = ['status'=>true,'info'=>'保存成功','id'=>$notepad->id ];
                return json($data);
            }
            $res = $notepad->save();
            if($res){
                $data = ['status'=>true,'info'=>'保存成功','id'=>$notepad->id ];
                return json($data);
            }else{
                $data = ['status'=>false,'info'=>'保存失败' ];
                return json($data);
            }
        }

    }

    public function submitImage()
    {
        // 去掉非post请求
        if(!request()->isPost())
        {
            dump('error.');
            die;
        }
        $file =request()->file("file");
        $data = [];
        if(empty($file))
        {
            $data = ['status'=>false,'info'=>'没有有效数据'];
            return json($data);
        }
        $info = $file->validate(['size'=>2024000,'ext'=>'jpeg,jpg,png,gif'])->move(ROOT_PATH . 'public/static' . DS . 'uploads/notepads/images');//图片保存路径 最大2M
        if ($info) {
            $data = ['status'=>true,'info'=>'/uploads/notepads/images/'.$info->getSaveName()];
        }else{
            $data = ['status'=>false,'info'=>$file->getError()];
        }
        return json($data);
    }
}
