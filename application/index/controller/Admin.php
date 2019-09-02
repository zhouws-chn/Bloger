<?php
namespace app\index\controller;

use app\common\controller\AdminBase;
use think\Validate;
use app\index\logic\Article;
class Admin extends AdminBase
{
    public function editArticle()
    {
        return $this->fetch('editarticle');
    }

    public function submitArticle()
    {
        // 去掉非post请求
        if(!request()->isPost())
        {
            dump('error.');
            die;
        }
        $validate = new Validate( [
            'title' => 'require|max:60|min:3',
            'content' => 'require|min:6',
            'cate_name' => 'require|max:16|min:3'
        ]);
        
        $data=[
            'title' => input('title'),
            'content' => input('ueditor_content'),
            'cate_name' => input('cate_name')
        ];
        if( !$validate->check($data))
        {
            $data = ['status'=>false,'info'=>$validate->getError()];
            return json($data);
        }

        
        $article = new Article();
        $res = $article->addArticle($data);
        if( $res['status'] )
        {
            $data = ['status'=>true,'info'=>'添加成功'];
            
        }else{
            $data = ['status'=>false,'info'=>$res['msg']];
            
        }
        return json($data);
    }
}
