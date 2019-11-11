<?php
namespace app\index\controller;

use app\common\controller\AdminController;
use app\index\logic\User;
use \think\File;
class Cate extends AdminController
{
    public function adminList(){
        return $this->fetch("adminlist");
    }

    public  function delete(){
        // 去掉非post请求
        if(!request()->isPost())
        {
            dump('error.');
            die;
        }
        $id = input('id');
        $passwd = input('passwd');

        if(empty($id)){
            $data = ['status'=>false,'info'=>"数据有误"];
            return json($data);
        }
        if(mb_strlen($passwd)<6){
            $data = ['status'=>false,'info'=>"数据有误"];
            return json($data);
        }
        $user = new User();
        if( $user->VertifyPasswd($passwd) )
        {
            $cate = \think\Loader::model('Cate')::get(['id'=>$id]);;
            $result = $cate->delete();
            if( $result ) {
                $data = ['status'=>true,'info'=>"success"];
                return json($data);
            }else{
                $data = ['status'=>false,'info'=>"暂未开放此功能"];
                return json($data);
            }

        }else{
            $data = ['status'=>false,'info'=>"密码错误"];
            return json($data);
        }


    }

    public  function add(){
        // 去掉非post请求
        if(!request()->isPost())
        {
            dump('error.');
            die;
        }
        $data=[
            'name' => input('cate_name'),
            'priority' => input('index')
        ];

        $cate = \think\Loader::model('Cate');
        $result = $cate->validate(true)->save($data);
        if($result === false) {
            $data = ['status'=>false,'info'=>$cate->getError()];
            return json($data);
        }

        $data = ['status'=>true,'info'=>"添加成功"];
        return json($data);
    }

    public  function update(){
        // 去掉非post请求
        if(!request()->isPost())
        {
            dump('error.');
            die;
        }
        $data=[
            'name' => input('cate_name'),
            'priority' => input('index')
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
}
