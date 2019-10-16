<?php
namespace app\index\validate;
use think\Validate;

class Article extends Validate{
   protected $rule = [
        'author_id' => 'require',
        'content' => 'require',
        'cate_id' => 'require',
        'title' => 'require|max:78|unique:articles'
   ];
   protected $message = [
    'author_id' => '没有作者信息',
    'content' => '没有内容',
    'cate_id' => '没有分类',
    'title.require' => '请输入标题',
    'title.unique' => '文章已发布过了'
];

}