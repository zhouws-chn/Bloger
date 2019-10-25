<?php
namespace app\index\controller;

use app\common\controller\AdminController;
use think\Session;
class Admin extends AdminController
{
    public function myZone()
    {
        // 去掉非get请求
        if(!request()->isGet())
        {
            dump('error.');
            die;
        }

        $tab_id = input('tab');
        if(!is_numeric ($tab_id)){
            $tab_id = 1;
        }
        $this->assign('tab',(int)$tab_id);

        $user = \think\Loader::model('User')::get(['id'=>Session::get('uid')]);
        $this->assign('user',$user);
        return $this->fetch("my_zone");
    }

    public function cateLists(){
        // 去掉非get请求
        if(!request()->isGet())
        {
            dump('error.');
            die;
        }
        $limit_num = input("limit");
        $article_num = \think\Loader::model('Cate')::count();
        $articles = \think\Loader::model('Cate')::order('id', 'desc')->paginate($limit_num);
        $data['code'] = 0;
        $data['msg'] = "top_msg";
        $data['count'] = $article_num;
        $data['data'] = $articles->toArray()['data'];
        return json($data);
    }

    public function updateCate(){
        // 去掉非get请求
        if(!request()->isGet())
        {
            dump('error.');
            die;
        }
        $cate_id = input('id');
        if(is_null($cate_id)){
            $this->assign('this_cate_id',null);
            return $this->fetch("iframe_update_cate");
        }

        $this->assign('this_cate_id',$cate_id);
        return $this->fetch("iframe_update_cate");
    }

    public function updateCateProcess(){
        // 去掉非post请求
        if(!request()->isPost())
        {
            dump('error.');
            die;
        }

        $data=[
            'name' => input('name'),
            'priority' => input('priority')
        ];
        $id= input('id');
        if(empty($id))
        {
            die;
        }

        $cate = \think\Loader::model('Cate')::get($id);
        if(is_null($cate))
        {
            die;
        }
        if( $cate->name == $data['name'] )
        {
            unset( $data['name'] );
        }
        if( $cate->priority == $data['priority'] )
        {
            unset( $data['priority'] );
        }
        if(empty($data))
        {
            $data = ['status'=>false,'info'=>"未发生变化"];
            return json($data);
        }

        $result = $cate->validate([
            'name' => 'max:12|unique:cates',
            'priority' => 'number|max:2|unique:cates'
        ])->save($data,['id' => $id]);

        if($result === false) {
            $data = ['status'=>false,'info'=>$cate->getError()];
            return json($data);
        }

        $data = ['status'=>true,'info'=>"修改成功"];
        return json($data);

    }


    public function getUploadImgs()
    {
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
        return $this->fetch('getUploadImgs');
    }
    public function getUploadImgsPost()
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
        $info = $file->validate(['size'=>124000,'ext'=>'jpg'])->move(ROOT_PATH . 'public/static' . DS . 'images/cates',strval($id).".jpg");
        //$info = $file->validate(['size'=>124000,'ext'=>'jpg'])->move(ROOT_PATH . 'public/static' . DS . 'images/cates');//图片保存路径 最大2M
        if ($info) {

            $data = ['status'=>true,'info'=>$info->getSaveName()];
        }else{
            $data = ['status'=>false,'info'=>$file->getError()];
        }
        return json($data);

    }
/* 获取轮播图信息 */
    public function carouselLists(){
        // 去掉非get请求
        if(!request()->isGet())
        {
            dump('error.');
            die;
        }
        $limit_num = input("limit");
        $carousel_num = \think\Loader::model('Carousel')::count();
        $carousels = \think\Loader::model('Carousel')::order('id', 'desc')->paginate($limit_num);
        $data['code'] = 0;
        $data['msg'] = "top_msg";
        $data['count'] = $carousel_num;
        $data['data'] = $carousels->toArray()['data'];
        return json($data);
    }
    /* 轮播图添加界面 */
    public function carouselAddIndex(){
        //$this->assign('this_carousel',null);
        return $this->fetch("carousel_add_index");
    }
}
