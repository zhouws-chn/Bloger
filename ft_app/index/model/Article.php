<?php
namespace app\index\model;
use think\Model;


class Article extends Model{
    protected $table = 'articles';
    protected $autoWriteTimestamp=true;
    protected $createTime = 'create_time';
    protected $readonly = ['id','create_time'];

    public function reply()
    {
        return $this->hasMany('replies','aid');
    }

    public function cate()
    {
        return $this->hasOne('cate','id', 'cate_id')->bind([
            'cate_name' => 'name',
        ]);
    }


}