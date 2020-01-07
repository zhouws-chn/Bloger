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
        // 摘要处理
        if(empty($data['abstract'])){
            $data['abstract_is'] = 0;
            $data['abstract'] = strip_tags(html_entity_decode($data['content']));
            // 删除中文空格
            $data['abstract'] = preg_replace ( "/\s+(?=[\x{4e00}-\x{9fa5}]+)/u"," ",$data['abstract']);
            $data['abstract'] = mb_substr($data['abstract'],0,99);
        }else{
            $data['abstract_is'] = 1;
            $data['abstract'] = strip_tags(html_entity_decode($data['abstract']));
            // 删除中文空格
            $data['abstract'] = preg_replace ( "/\s+(?=[\x{4e00}-\x{9fa5}]+)/u"," ",$data['abstract']);
            $data['abstract'] = mb_substr($data['abstract'],0,499);
        }
        unset($data['cate_name']);
        $result = $article->validate(true)->save($data);
        if($result === false) {
            $res['status']=false;
            $res['msg']=$article->getError();
            return $res;
        }
        $res['status']=true;
        return $res;

    }

    public function updateArticle( $data ){
        $user = \think\Loader::model('User','logic');
        $cate = \think\Loader::model('Cate')::get(['name'=>$data['cate_name']]);
        if(!$cate){
            return ['status'=>false, 'info'=>'栏目不存在:'.$data['cate_name']];
        }
        $data['cate_id']=$cate['id'];
        $data['author_id'] = Session::get('uid');
        $article = \think\Loader::model('Article')::get($data['id']);
        // 摘要处理
        if(empty($data['abstract'])){
            $data['abstract_is'] = 0;
            $data['abstract'] = strip_tags($data['content']);
            // 删除中文空格
            $data['abstract'] = preg_replace ( "/\s+(?=[\x{4e00}-\x{9fa5}]+)/u"," ",$data['abstract']);
            $data['abstract'] = mb_substr($data['abstract'],0,99);
        }else{
            $data['abstract_is'] = 1;
            $data['abstract'] = strip_tags($data['abstract']);
            // 删除中文空格
            $data['abstract'] = preg_replace ( "/\s+(?=[\x{4e00}-\x{9fa5}]+)/u"," ",$data['abstract']);
            $data['abstract'] = mb_substr($data['abstract'],0,499);
        }
        unset($data['cate_name']);
        //$data['content'] = str_replace(PHP_EOL, '', $data['content']);
        //dump($data['content']);die;
        $result = $article->validate(true)->save($data);
        if($result === false) {
            $res['status']=false;
            $res['info']=$article->getError();
            return $res;
        }
        $res['status']=true;
        return $res;

    }

    public function GetIndexArticle(){

    }
}