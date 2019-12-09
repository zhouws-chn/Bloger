<?php
namespace app\index\controller;

use app\common\controller\AdminController;
use think\Session;
use \think\File;
use think\Config;

class Carousel extends AdminController
{

    public function addProcess(){
        // 去掉非post请求
        if(!request()->isPost())
        {
            dump('error.');
            die;
        }

        $data=[
            'name' => input('name'),
            'url' => input('url')
        ];
        $carousel = \think\Loader::model('Carousel');
        $result = $carousel->validate(true)->save($data);
        if($result === false) {
            $data = ['status'=>false,'info'=>$carousel->getError()];
            return json($data);
        }

        $data = ['status'=>true,'info'=>"添加成功"];
        return json($data);
    }

    public function delete()
    {
        // 去掉非post请求
        if(!request()->isPost())
        {
            dump('error.');
            die;
        }
        $count = \think\Loader::model('Carousel')::count();
        if($count<2){
            $data = ['status'=>false,'info'=>"不可以删除全部的轮播图"];
            return json($data);
        }

        $carousel_id = input('id');
        $carousel = \think\Loader::model('Carousel')::get(['id'=>$carousel_id]);
        $res = $carousel->delete();
        if($res) {
            $data = ['status'=>true,'info'=>'删除成功'];
            return json($data);
        }
        $data = ['status'=>false,'info'=>'删除失败'];
        return json($data);
    }

    public function edit(){
        $carousel_id = input('id');
        if(is_null($carousel_id)){
            die;
        }
        $carousel = \think\Loader::model('Carousel')::get(['id'=>$carousel_id]);
        $this->assign('this_carousel',$carousel);
        return $this->fetch("edit");
    }

    public  function editProcess(){
        // 去掉非post请求
        if(!request()->isPost())
        {
            dump('error.');
            die;
        }
        $data=[
            'name' => input('name'),
            'priority' => input('priority'),
            'url' => input('url')
        ];
        $id= input('id');
        if(empty($id))
        {
            die;
        }

        $carousel = \think\Loader::model('Carousel')::get($id);
        if(is_null($carousel))
        {
            die;
        }
        if( $carousel->name == $data['name'] )
        {
            unset( $data['name'] );
        }
        if( $carousel->priority == $data['priority'] )
        {
            unset( $data['priority'] );
        }
        if( $carousel->url == $data['url'] )
        {
            unset( $data['url'] );
        }
        if(empty($data))
        {
            $data = ['status'=>false,'info'=>"未发生变化"];
            return json($data);
        }

        $result = $carousel->validate([
            'name' => 'max:12|unique:carousels',
            'priority' => 'number|max:2|unique:carousels',
            'url' => 'min:2'
        ])->save($data,['id' => $id]);

        if($result === false) {
            $data = ['status'=>false,'info'=>$carousel->getError()];
            return json($data);
        }

        $data = ['status'=>true,'info'=>"修改成功"];
        return json($data);
    }

    public function editImage(){
        // 去掉非get请求
        if(!request()->isGet())
        {
            dump('error.');
            die;
        }
        $id= input('id');
        if(empty($id))
        {
            die;
        }
        $this->assign('id',$id);
        return $this->fetch("uploadimg");
    }

    public function editImagePost()
    {
        $id = input("id");
        if(empty($id)){
            $data = ['status'=>false,'info'=>'没有有效数据'];
            return json($data);
        }
        $file =request()->file("file");
        if(empty($file))
        {
            $data = ['status'=>false,'info'=>'没有有效数据'];
            return json($data);
        }
        $data = [];
        // http://localhost/static/images/cates/3.jpg
        $info = $file->validate(['size'=>824000,'ext'=>'jpg'])->move(ROOT_PATH . 'public/static' . DS . 'images/carousel',strval($id).".jpg");
        //$info = $file->validate(['size'=>124000,'ext'=>'jpg'])->move(ROOT_PATH . 'public/static' . DS . 'images/cates');//图片保存路径 最大2M
        if ($info) {
            $data = ['status'=>true,'info'=>$info->getSaveName()];
            return json($data);
        }else{
            $data = ['status'=>false,'info'=>$file->getError()];
            return json($data);
        }
    }

}
