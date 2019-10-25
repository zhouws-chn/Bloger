<?php
namespace app\index\validate;
use think\Validate;

class Notification extends Validate{
    protected $rule = [
        'title' => 'require|min:4|unique:notifications|max:250',
        'content' => 'require|min:2'
    ];
    protected $message = [
        'title' => '公告标题错误',
        'content' => '公告内容错误'
    ];

}