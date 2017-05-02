<?php

namespace Share\BusinessModels;

use Share\Models\Enewsclass as DbEnewsclass;
use Share\Services\Search\SystemArticleSearch;
use Cache;

class Enewsclass extends Model{
    private $dbPre = null;

    public function __construct($id)
    {
        $this->dbPre = config('cwzg.edbPrefix');
        $this->attributes['classid'] = $id;
    }

    private function getClassInfo(){
        $cacheId = 'enewclas-model-'.$this->attributes['classid'];
        return Cache::remember($cacheId, CACHE_TIME, function(){
            return DbEnewsclass::find($this->attributes['classid']);
        });
    }
    
    public function asynLoad1(){
        $this->model = $this->getClassInfo();
        $this->attributes['url'] = url('/'.$this->model->classpath);
    }
}