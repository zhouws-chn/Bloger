<?php
namespace app\index\controller;

use app\common\controller\BaseController;
use app\index\model\Article;
use app\index\model\Carousel;
class Index extends BaseController
{
    public function index()
    {
        $carousels = Carousel::field('id,url')->order('priority','esc')->select();
        $this->assign('carousels',$carousels);

        $articles = Article::field('id,title,abstract,title_img,cate_id,cate_name,pv,create_time,update_time')->order('create_time','desc')->limit(10)->select();
        $this->assign('articles',$articles);

        $notifications = \think\Loader::model('Notification')::field('id,title,create_time')->order('create_time','desc')->select();
        if(!$notifications){
            return $this->error("公告不存在");
        }
        $this->assign('notifications',$notifications);
        
        return $this->fetch();
    }
}
