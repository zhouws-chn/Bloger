<?php
namespace app\notepad\controller;

use app\common\controller\UserController;
class Mind extends UserController
{
    public function index()
    {
        return $this->fetch('index');
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
            'id' =>  (int)input('id')
        ];
        if($data['id'] == 0){
            $notepad = new \app\notepad\model\Mind();
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
            $notepad = \think\Loader::model('Mind')::get(['id'=>$data['id']]);
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

    public function update()
    {
        // 去掉非post请求
        if(request()->isGet())
        {
            return $this->fetch('update');
        }else if(request()->isPost())
        {
            $id = input('id');
            $notepad = \think\Loader::model('Mind')::get(['id'=>$id]);
            $data = ['status'=>true,'info'=>'保存成功','id'=>$notepad->id,'title'=>$notepad->title,'content'=>$notepad->content ];
            return json($data);
        }

    }

    public function delete()
    {
        if(request()->isPost())
        {
            $id = input('id');
            $notepad = \think\Loader::model('Mind')::get(['id'=>$id]);
            $notepad->delete();
            $data = ['status'=>true,'info'=>'删除成功','id'=>$notepad->id ];
            return json($data);
        }
    }
}
