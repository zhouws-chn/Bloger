<?php
namespace app\index\controller;

use app\common\controller\AdminBase;
use app\index\logic\User;
class Cate extends AdminBase
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
}
