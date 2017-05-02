<?php

namespace Share\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model{

    protected $table = "wx_article";
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function content(){
        return $this->hasOne('Share\Models\ArticleData','id','id');
    }

}