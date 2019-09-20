<?php
namespace app\index\validate;
use think\Validate;

class Cate extends Validate{
   protected $rule = [
        'name' => 'require|max:12|unique:cates',
        'priority' => 'number|max:2|unique:cates'
   ];
}