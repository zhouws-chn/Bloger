<?php
namespace app\index\controller;

use app\common\controller\BaseController;

class Article extends BaseController
{
    public function detial()
    {   
        // 去掉非get请求
        if(!request()->isGet())
        {
            dump('error.');
            die;
        }

        $article_id = input('id');
        $article = \think\Loader::model('Article')::get(['id'=>$article_id]);
        if(!$article){
            return $this->error("文章不存在");
        }
        $article->setInc('pv');
        $this->assign('article',$article);

        return $this->fetch('article');
    }
    public function cate()
    {
        // 去掉非get请求
        if(!request()->isGet())
        {
            dump('error.');
            die;
        }
        $cate_id = input('id');
        $articles = \think\Loader::model('Article')::where('cate_id',$cate_id)->field('id,title,abstract,title_img,cate_id,cate_name,pv,update_time')->order('update_time','desc')->limit(10)->select();
        if(!$articles) {
            return $this->error('没有文章');
        }
        $this->assign('articles',$articles);
        return $this->fetch('list');
    }
}
