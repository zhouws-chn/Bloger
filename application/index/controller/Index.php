<?php
namespace app\index\controller;

use app\common\controller\BaseController;
use app\index\model\Article;
class Index extends BaseController
{
    public function index()
    {
        $articles = Article::field('id,title,abstract,title_img,cate_id,cate_name,pv,update_time')->order('update_time','desc')->limit(10)->select();
        
        $this->assign('articles',$articles);
        
        return $this->fetch();
    }
}
