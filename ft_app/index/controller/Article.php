<?php
namespace app\index\controller;

use app\common\controller\BaseController;
use think\Session;
use \think\File;

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
        foreach ($articles as $article )
        {
            $this->assign('cate_name',$article['cate_name']);
            break;
        }
        $this->assign('articles',$articles);
        return $this->fetch('list');
    }

    // 以下代码  需要添加登陆权限验证

    private  function LoginVerify(){
        if(!Session::has('uname'))
        {
            $this->error('您还没有登陆,请先登陆',url('/index/Login/index'));
        }
    }

    public function editArticle()
    {
        $this->LoginVerify();
        return $this->fetch('editarticle');
    }

    public function updateArticle()
    {
        $this->LoginVerify();

        // 去掉非get请求
        if(!request()->isGet())
        {
            dump('error.');
            die;
        }
        $article_id = input('id');
        $article = \think\Loader::model('Article')::get(['id'=>$article_id]);
        if(!$article) {
            return $this->error('没有文章');
        }
        $this->assign('article',$article);
        return $this->fetch('updatearticle');
    }

    public function submitArticle()
    {
        $this->LoginVerify();
        // 去掉非post请求
        if(!request()->isPost())
        {
            dump('error.');
            die;
        }
        $data=[
            'title' => input('title'),
            'content' => input('article_content'),
            'cate_name' => input('cate_name'),
            'abstract' => input('abstract')
        ];
        $article = \think\Loader::model('Article','logic');
        $res = $article->addArticle($data);
        if( $res['status'] )
        {
            $data = ['status'=>true,'info'=>'添加成功'];

        }else{
            $data = ['status'=>false,'info'=>$res['msg']];

        }
        return json($data);
    }

    public function submitArticleImage()
    {
        $this->LoginVerify();
        // 去掉非post请求
        if(!request()->isPost())
        {
            dump('error.');
            die;
        }
        $file =request()->file("file");
        $data = [];
        if(empty($file))
        {
            $data = ['status'=>false,'info'=>'没有有效数据'];
            return json($data);
        }
        $info = $file->validate(['size'=>2024000,'ext'=>'jpeg,jpg,png,gif'])->move(ROOT_PATH . 'public/static' . DS . 'uploads/images');//图片保存路径 最大2M
        if ($info) {

            $data = ['status'=>true,'info'=>$info->getSaveName()];
        }else{
            $data = ['status'=>false,'info'=>$file->getError()];
        }
        return json($data);
    }

    public function changeArticle()
    {
        $this->LoginVerify();
        // 去掉非post请求
        if(!request()->isPost())
        {
            dump('error.');
            die;
        }
        $data=[
            'id' => input('id'),
            'title' => input('title'),
            'content' => input('article_content'),
            'cate_name' => input('cate_name'),
            'abstract' => input('abstract')
        ];
        $article = \think\Loader::model('Article','logic');
        $res = $article->updateArticle($data);
        if( $res['status'] )
        {
            $data = ['status'=>true,'info'=>'修改成功'];

        }else{
            $data = ['status'=>false,'info'=>$res['msg']];

        }
        return json($data);
    }
    public function delete()
    {
        $this->LoginVerify();
        // 去掉非get请求
        if(!request()->isPost())
        {
            dump('error.');
            die;
        }

        $article_id = input('id');
        $article = \think\Loader::model('Article')::get(['id'=>$article_id]);
        $res = $article->delete();
        if($res) {
            $data = ['status'=>true,'info'=>'删除成功'];
            return json($data);
        }
        $data = ['status'=>false,'info'=>'删除失败'];
        return json($data);
    }
}