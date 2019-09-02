<?php
namespace app\index\logic;
use think\Model;
use think\Session;

class Article extends Model{

    public function addArticle( $data ){
        
        $cate = \think\Loader::model('Cate')::get(['name'=>$data['cate_name']]);
        if(!$cate){
            return 2;
        }
        $data['cate_id']=$cate['id'];
        $data['author_id'] = Session::get('uid');
        $article = \think\Loader::model('Article');
        $result = $article->validate(true)->save($data);
        if($result === false) {
            $res['status']=false;
            $res['msg']=$article->getError();
            return $res;
        }
        $res['status']=true;
        return $res;

    }

    public function GetIndexArticle(){

    }
}