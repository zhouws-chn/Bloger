<?php
namespace app\index\model;
use think\Model;
class Carousel extends Model{
    protected $table = 'carousels';
    protected $autoWriteTimestamp=true;
    protected $readonly = ['id'];
    protected $updateTime = false;

}