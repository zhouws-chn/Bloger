<?php
namespace app\index\model;
use think\Model;
class Reply extends Model{
    protected $table = 'replies';
    protected $autoWriteTimestamp=true;
    protected $readonly = ['id'];

    public function user()
    {
        return $this->hasOne('user','id', 'uid')->bind([
            'uname' => 'name',
            'uhead_img' => 'head_img'
        ]);
    }
    public function article()
    {
        return $this->hasOne('Article','id', 'aid')->bind([
            'atitle' => 'title'
        ]);
    }
}