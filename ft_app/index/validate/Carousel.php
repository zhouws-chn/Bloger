<?php
namespace app\index\validate;
use think\Validate;

class Carousel extends Validate{
    protected $rule = [
        'name' => 'require|min:4|unique:carousels',
        'url' => 'require|min:2'
    ];
    protected $message = [
        'name' => '轮播图标题错误',
        'url' => '轮播图链接错误'
    ];

}