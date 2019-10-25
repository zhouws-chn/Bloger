<?php
namespace app\index\model;
use think\Model;
class Cate extends Model{
    protected $table = 'cates';
    protected $readonly = ['id'];
    protected $resultSetType = 'collection';
    protected $autoWriteTimestamp=true;
    protected $updateTime = false;


}