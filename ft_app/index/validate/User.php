<?php
namespace app\index\validate;
use think\Validate;

class User extends Validate{
   protected $rule = [
        'email' => 'require|email|unique:users',
        'passwd' => 'require',
        'name' => 'require|max:16|min:2|unique:users'
   ];

   protected $message = [
       'email.unique' => '邮箱已存在',
   ];
}