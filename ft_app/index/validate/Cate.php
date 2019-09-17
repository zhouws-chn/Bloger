<?php
namespace app\index\validate;
use think\Validate;

class Cate extends Validate{
   protected $rule = [
        'name' => 'require|unique:cates'
   ];
}