<?php
namespace app\index\model;
use think\Model;


class Article extends Model{
    protected $table = 'articles';
    protected $autoWriteTimestamp=true;
    protected $createTime = 'create_time';
    protected $readonly = ['id','create_time'];


}