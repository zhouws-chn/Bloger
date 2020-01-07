<?php
namespace app\index\controller;

use app\common\controller\UserController;

class Uarticle extends UserController
{
    public function updateArticle()
    {
        // 去掉非get请求
        if(!request()->isGet())
        {
            dump('error.');
            die;
        }
        $article_id = input('id');
        $article = \think\Loader::model('Article')::with('cate')->where('id',$article_id)->field('id,title,abstract_is,origin_url,abstract,title_img,cate_id,pv,create_time,update_time')->find();
        if(!$article) {
            return $this->error('没有文章');
        }
        $this->assign('article',$article->toArray());
        return $this->fetch('updatearticle');
    }

    public function editArticle()
    {
        return $this->fetch('editarticle');
    }

    public function delete()
    {
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

    public function articlecontent(){
        $article_id = input('id');
        $article = \think\Loader::model('Article')::get(['id'=>$article_id],'cate');
        if(!$article){
            $data = ['status'=>false,'info'=>'文章不存在'];
            return json($data);
        }

        $data = ['status'=>true,'info'=>$article['content']];
        return json($data);
    }

    public function changeArticle()
    {
        if(!request()->isPost())
        {
            dump('changeArticle error.');
            die;
        }
        $data=[
            'id' => input('id'),
            'title' => input('title'),
            'content' => input('article_content'),
            'cate_name' => input('cate_name'),
            'abstract' => input('abstract'),
            'origin_url' => input('origin_url')
        ];
        $get_pic = input('get_pic');
        if(!empty($get_pic)){
            $config_view_replace_str = config("view_replace_str");
            $this_url = $config_view_replace_str['__WEB_URL_PROTOCOL__'].'\\\\'.$config_view_replace_str['__WEB_URL_HOSTNAME__'];
            $this_url_len = strlen($this_url);
            $pic_url_all = get_pic_url_from_html($data['content']);
            // TODO:去除重复的url
            $pic_url_all = array_flip($pic_url_all);
            $pic_url_all = array_keys($pic_url_all);
            /* 遍历 */
            $ch = curl_init();
            foreach ($pic_url_all as $pic_url) {
                // TODO: 过滤掉本站图片的URL
                // 首先过滤掉非http开头的url
                if(substr($pic_url,0,4) == "http"){
                    // 再过滤掉包含本站url的URL
                    if((strlen($pic_url)-$this_url_len<0)||(substr($pic_url,0,$this_url_len) != $this_url_len)){
                        // TODO:下载图片
                        $result_pic_url = pic_download_from_url($pic_url);
                        // TODO: 将保存后的地址赋值给 $result_pic_url
                        if( $result_pic_url != $pic_url)
                            $data['content'] = str_replace($pic_url,$result_pic_url,$data['content']);
                    }
                }
            }
        }
        $article = \think\Loader::model('Article','logic');
        $res = $article->updateArticle($data);
        if( $res['status'] )
        {
            $data = ['status'=>true,'info'=>'修改成功'];

        }else{
            $data = ['status'=>false,'info'=>$res['info']];

        }
        return json($data);
    }

}
