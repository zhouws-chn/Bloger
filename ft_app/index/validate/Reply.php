<?php
namespace app\index\validate;
use think\Validate;

class Reply extends Validate{
    protected $rule = [
        'content' => 'require|min:6|max:255'
    ];

}