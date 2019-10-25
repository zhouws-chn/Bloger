<?php
namespace app\index\model;
use think\Model;


class Draft extends Model{
    protected $table = 'drafts';
    protected $autoWriteTimestamp=true;
    protected $updateTime = 'create_time';
    protected $createTime = false;
    protected $readonly = ['id','create_time'];

}
