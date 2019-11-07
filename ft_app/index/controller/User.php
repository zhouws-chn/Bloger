<?php
namespace app\index\controller;

use app\common\controller\UserController;
use think\Session;
class User extends UserController
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
        }else if( $tab_id>3 ||  $tab_id<1 ){
            $tab_id = 1;
        }
        if(Session::has('uAdmin'))
        {
            $this->redirect('Admin/myZone',array('tab'=>$tab_id));
        }

        $this->assign('tab',(int)$tab_id);
        $user = \think\Loader::model('User')::get(['id'=>Session::get('uid')]);
        $this->assign('user',$user);

        return $this->fetch("my_zone");
    }

    public function updateUserData()
    {
        // 去掉非post请求
        if(!request()->isPost())
        {
            dump('error.');
            die;
        }
        $uname = input('name');
        $uemail = input('email');
        $description = input("desc");
        $passwd = input("oPassword");
        if(strlen($passwd)<6){
            $data = ['status'=>false,'info'=>'密码格式错误'];
            return json($data);
        }
        $npasswd = input("nPassword1");
        $npasswd2 = input("nPassword2");
        if(strlen($npasswd)!=0) {
            if ((strlen($npasswd)<6) || (strlen($npasswd)!=strlen($npasswd2)) || (strlen($npasswd)>18)) {
                $data = ['status'=>false,'info'=>'新密码格式错误'];
                return json($data);
            }
        }
        // 密码验证
        $logicUser = \think\Loader::model('User','logic');
        $vpRes = $logicUser->VertifyPasswd($passwd);
        if( !$vpRes ) {
            $data = ['status'=>false,'info'=>'密码错误'];
            return json($data);
        }

        // 更改密码
        if(strlen($npasswd)!=0){
            $upRes = $logicUser->updatePasswd($npasswd);
            if(!$upRes){
                $data = ['status'=>false,'info'=>'密码修改失败'];
                return json($data);
            }
        }
        $uData['name'] = $uname;
        $uData['email'] = $uemail;
        $uData['description'] = $description;
        $uuRes = $logicUser->updateUserData($uData);

        if($uuRes){
            $data = ['status'=>true,'info'=>'资料修改成功'];
            return json($data);
        }else{
            $data = ['status'=>false,'info'=>'资料修改失败'];
            return json($data);
        }


    }

    // 验证管理员权限
    public function verifyAdmin(){
        // 去掉非post请求
        if(!request()->isPost())
        {
            dump('error.');
            die;
        }
        $password = input("password");
        if(empty($password)){
            dump('error.');
            die;
        }
        if(strlen($password)<6){
            dump('error.');
            die;
        }
        $logicUser = \think\Loader::model('User','logic');
        $vaRes = $logicUser->VertifyAdmin($password);
        if($vaRes){
            $data = ['status'=>true,'info'=>'权限验证成功'];
            return json($data);
        }else{
            $data = ['status'=>false,'info'=>'权限验证失败'];
            return json($data);
        }
    }

    public function articleLists(){
        // 去掉非get请求

        $articles = null;
        $limit_num = input("limit");
        $cate_name = input("cate_name");
        $articlesModel = \think\Loader::model('Article');

        if(is_null($cate_name)){
            $articles = $articlesModel::where(['author_id'=>Session::get('uid')]);
        } else {
            $articles = $articlesModel::where(['author_id'=>Session::get('uid'),'cate_name'=>$cate_name]);
        }

        if(empty($articles)){
            $data['code'] = 0;
            $data['msg'] = "top_msg";
            $data['count'] = 0;
            $data['data'] = [""];
            return json($data);
        }

        $article_items = $articles->field('id,title,cate_name,create_time')->order('id', 'desc')->paginate($limit_num)->all();
        $article_num = $articles->field('id,title,cate_name,create_time')->order('id', 'desc')->count();
        $articles = collection($article_items)->toArray();
        //$article_num = count($articles);
        $data['code'] = 0;
        $data['msg'] = "top_msg";
        $data['count'] = $article_num;
        $data['data'] = $articles;
        return json($data);
    }

    public function cateList(){
        $data = [];
        $cates = \think\Loader::model('Cate')::field('id,name,priority')->order('priority', 'desc')->select();
        $data['code'] = 0;
        $data['msg'] = "top_msg";
        $cate_index = 0;
        foreach($cates->toArray() as $value){
            $data['data'][$cate_index]=['value'=>$value['name'],'key'=>$value['name']];
            $cate_index = $cate_index+1;
        }
        return json($data);
    }


}
