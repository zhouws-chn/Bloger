<?php
namespace app\notepad\model;
use think\Model;


class Mind extends Model{
    protected $table = 'minds';
    protected $autoWriteTimestamp=true;
    protected $createTime = 'create_time';
    protected $readonly = ['id','create_time'];

    public function cate()
    {
        return $this->hasOne('cate','id', 'cate_id')->bind([
            'cate_name' => 'name',
        ]);
    }


}