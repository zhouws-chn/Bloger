<?php
namespace app\index\controller;

use app\common\controller\UserController;
use think\Session;
use think\Request;
use think\Validate;

class Reply extends UserController
{
    //  添加评论
    public function Add()
    {
        // 去掉非post请求
        if(!request()->isPost())
        {
            dump('error.');
            die;
        }
        $data=[
            'aid' => input('id'),
            'content' => input('content')
        ];
        $data['uid'] = Session::get('uid');
        $reply = \think\Loader::model('Reply');
        $res = $reply->validate(true)->save($data);
        if($res === false) {
            $data = ['code'=>0,'msg'=>"回复失败:".$reply->getError()];
            return json($data);
        }
        $data = ['code'=>1,'msg'=>"回复成功"];
        return json($data);
    }

    // 请求验证账号密码 Post信息
    public function Login()
    {
        // 去掉非post请求
        if(!request()->isPost())
        {
            dump('error.');
            die;
        }

        if(Session::has('uname'))
        {
            // 已经登陆 直接返回到首页
            $data = ['status'=>false,'info'=>'已经登陆过了,不需要再次登陆'];
            return json($data);
        }

        $validate = new Validate( [
            'email' => 'require|max:25|min:3',
            'passwd' => 'require|max:18|min:6',
            'verifyCode'  => 'require|length:4'
        ]);
        //连接数据库,判断密码的正确性
        $data=[
            'email' => input('email'),
            'passwd' => input('password'),
            'verifyCode' => input('verify_code')
        ];
        if( !$validate->check($data))
        {
            $data = ['status'=>false,'info'=>$validate->getError()];
            return json($data);
        }
        if(!captcha_check($data['verifyCode']))
        {
            $data = ['status'=>false,'info'=>'验证码不正确'];
            return json($data);
        }
        $user = new User();
        if( $user->LoginVertify($data) )
        {
            $data = ['status'=>true,'info'=>'登陆成功'];

        }else{
            $data = ['status'=>false,'info'=>'账户/密码有误'];

        }
        return json($data);
    }

    //
    public function Lists(){
        // 去掉非post请求
        if(request()->isPost())
        {
            dump('error.');
            die;
        }
        if(Session::has('uname') == false ){

            $data = ['status'=>false,'info'=>'error.'];
            return json($data);

        }

        $limit_num = input("limit");
        //dump(Session::get('uid'));die;
        $replys = \think\Loader::model('Reply')::with('article')->where(['uid'=>Session::get('uid')]);


        if(empty($replys)){
            $data['code'] = 0;
            $data['msg'] = "top_msg";
            $data['count'] = 0;
            $data['data'] = [];
            return json($data);
        }

        $draft_num = \think\Loader::model('Reply')::where(['uid'=>Session::get('uid')])->count();
        $draft_items = $replys->order('create_time', 'desc')->paginate($limit_num);

        $data['code'] = 0;
        $data['msg'] = "top_msg";
        $data['count'] = $draft_num;
        $data['data'] = $draft_items->toArray()['data'];
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
        if(Session::has('uname') == false ){

            $data = ['status'=>false,'info'=>'error.'];
            return json($data);

        }

        $article_id = input('id');
        $article = \think\Loader::model('Reply')::get(['id'=>$article_id]);
        $res = $article->delete();
        if($res) {
            $data = ['status'=>true,'info'=>'删除成功'];
            return json($data);
        }
        $data = ['status'=>false,'info'=>'删除失败'];
        return json($data);
    }

    // 请求退出
    public function Logout()
    {
        if(Session::has('uname'))
        {
            Session::clear();
            return $this->success('您已退出登陆','/');
        }
        return $this->error('您还没有登陆或已经成功退出','/');
    }

}
