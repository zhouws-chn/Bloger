<?php
namespace app\index\model;
use think\Model;

class User extends Model{
    protected $table = 'users';
    protected $autoWriteTimestamp=false;
    protected $createTime = 'create_time';
    protected $readonly = ['id','create_time'];

}