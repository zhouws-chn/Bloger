<?php
namespace app\index\model;
use think\Model;
class Notification extends Model{
    protected $table = 'notifications';
    protected $autoWriteTimestamp=true;
    protected $readonly = ['id'];
    protected $updateTime = false;

}