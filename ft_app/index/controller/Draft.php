<?php
namespace app\index\controller;

use app\common\controller\UserController;
use think\Session;
use \think\File;
use think\Config;

class Draft extends UserController
{
    public function myDraft(){

        return $this->fetch("my_list");
    }
    /* 草稿预览  使用article控制下的模板article  保证预览和发布效果一致 */
    public function previewDraft(){
        // 去掉非get请求
        if(!request()->isGet())
        {
            dump('error.');
            die;
        }
        $draft_id = input('id');
        if(is_null($draft_id)){
            die;
        }
        $article = \think\Loader::model('Draft')::get(['id'=>$draft_id],'cate');
        if(!$article){
            return $this->error("草稿不存在");
        }
        $article['pv'] = 0;
        $article['update_time'] = $article['create_time'];
        $this->assign('article',$article);
        $this->assign('replies',null);
        return $this->fetch('article/article');
    }
    /* 编辑草稿请求 */
    public function editDraft(){
        // 去掉非get请求
        if(!request()->isGet())
        {
            dump('error.');
            die;
        }
        $draft_id = input('id');
        $draft = \think\Loader::model('Draft')::get(['id'=>$draft_id],'cate');
        if(!$draft) {
            return $this->error('没有文章');
        }
        $this->assign('draft',$draft);
        return $this->fetch("editDraft");
    }
    /* 提交草稿请求 */
    public function submitDraft()
    {
        // 去掉非post请求
        if(!request()->isPost())
        {
            dump('error.');
            die;
        }
        $data=[
            'title' => input('title'),
            'content' => input('article_content'),
            'abstract' => input('abstract'),
            'cate_name' => input('cate_name'),
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

        $article = \think\Loader::model('Draft','logic');
        $res = $article->addArticle($data);
        if( $res['status'] )
        {
            $data = ['status'=>true,'info'=>'添加成功'];

        }else{
            $data = ['status'=>false,'info'=>$res['msg']];

        }
        return json($data);
    }

    public function draftcontent(){
        $draft_id = input('id');
        $article = \think\Loader::model('Draft')::get(['id'=>$draft_id],'cate');
        if(!$article){
            $data = ['status'=>false,'info'=>'文章不存在'];
            return json($data);
        }

        $data = ['status'=>true,'info'=>$article['content']];
        return json($data);
    }

    public function draftsLists(){
        // 去掉非get请求
        if(!request()->isGet())
        {
            dump('error.');
            die;
        }
        $limit_num = input("limit");
        $drafts = \think\Loader::model('Draft')::field('id,title,cate_id,create_time')->with('cate')->where(['author_id'=>Session::get('uid')]);
        $draft_num = \think\Loader::model('Draft')::where(['author_id'=>Session::get('uid')])->count();

        if(empty($drafts)){
            $data['code'] = 0;
            $data['msg'] = "top_msg";
            $data['count'] = 0;
            $data['data'] = [];
            return json($data);
        }
        $draft_items = $drafts->order('create_time', 'desc')->paginate($limit_num)->all();
        $data['code'] = 0;
        $data['msg'] = "top_msg";
        $data['count'] = $draft_num;
        $data['data'] = $draft_items;
        return json($data);
    }
    /* 打开已存在的草稿并保存 */
    function saveDraft(){
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
        $draft = \think\Loader::model('Draft','logic');
        $res = $draft->updateArticle($data);
        if( $res['status'] )
        {
            $data = ['status'=>true,'info'=>'修改成功'];

        }else{
            $data = ['status'=>false,'info'=>$res['msg']];

        }
        return json($data);
    }
    /* 删除草稿 */
    public function delete()
    {
        // 去掉非post请求
        if(!request()->isPost())
        {
            dump('error.');
            die;
        }

        $article_id = input('id');
        $article = \think\Loader::model('Draft')::get(['id'=>$article_id]);
        $res = $article->delete();
        if($res) {
            $data = ['status'=>true,'info'=>'删除成功'];
            return json($data);
        }
        $data = ['status'=>false,'info'=>'删除失败'];
        return json($data);
    }
    /* 直接发布草稿 */
    public function pushArticle()
    {
        // 去掉非post请求
        if(!request()->isPost())
        {
            dump('error.');
            die;
        }
        $article_id = input('id');
        $draft = \think\Loader::model('Draft')::get(['id'=>$article_id],'cate');
        if(empty($draft)){
            $data = ['status'=>true,'info'=>'error, not found Draft.'];
            return json($data);
        }
        $draft_data = $draft->toArray();

        unset($draft_data['id']);

        $draft_data['create_time']=time();
        $article = \think\Loader::model('Article','logic');
        $res = $article->addArticle($draft_data);
        if( $res['status'] )
        {
            $draft->delete();
            $data = ['status'=>true,'info'=>'添加成功'];

        }else{
            $data = ['status'=>false,'info'=>$res['msg']];

        }
        return $data;
    }
    /* 编辑界面发布草稿 */
    public function submitArticle()
    {
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
            'abstract' => input('abstract'),
            'origin_url' => input('origin_url')
        ];
        $draft_id = input('id');
        if(is_null($draft_id)){
            die;
            return ;
        }
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
        $res = $article->addArticle($data);
        if( $res['status'] )
        {
            $draft = \think\Loader::model('Draft')::get(['id'=>$draft_id]);
            $draft->delete();
            $data = ['status'=>true,'info'=>'发布成功'];

        }else{
            $data = ['status'=>false,'info'=>$res['msg']];

        }
        return json($data);
    }
}