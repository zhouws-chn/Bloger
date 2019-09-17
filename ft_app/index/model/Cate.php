<?php
namespace app\index\model;
use think\Model;
class Cate extends Model{
    protected $table = 'cates';
    protected $autoWriteTimestamp=false;
    protected $readonly = ['id'];

}