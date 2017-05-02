<?php

namespace Share\BusinessModels;

use Share\Services\Search\SystemArticleSearch;
use Cache;
use DB;

class InfoType extends Model{
    private $dbPre = null;

    public function __construct($id)
    {
        $this->dbPre = config('cwzg.edbPrefix');
        $this->attributes['typeid'] = $id;
    }

    private function getTypeInfo(){
        $cacheId = 'infotype-'.$this->attributes['typeid'];
        return Cache::remember($cacheId, CACHE_TIME, function(){
            return DB::table($this->dbPre.'enewsinfotype')->where('typeid', $this->attributes['typeid'])->first();
        });
    }

    public function asynLoad1(){
        $this->model = $this->getTypeInfo();
        $this->attributes['url'] = url('/'.$this->model->tpath);
    }
}