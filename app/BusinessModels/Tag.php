<?php

namespace Share\BusinessModels;

use Share\Services\Search\SystemArticleSearch;
use Cache;
use DB;

class Tag extends Model{
    private $dbPre = null;

    public function __construct($tagid)
    {
        $this->dbPre = config('cwzg.edbPrefix');
        $this->attributes['tagid'] = $tagid;
        $this->model = $this->getTagInfo();
        $this->attributes['url'] = url();
    }

    private function getTagInfo(){
        $cacheId = 'tag-'.$this->attributes['tagid'];
        return Cache::remember($cacheId, CACHE_TIME, function(){
            return DB::table($this->dbPre.'enewstags')->where('tagid', $this->attributes['tagid'])->first();
        });
    }

    public function getArticleIds(){
        $cacheId = 'tag-article-id-'.$this->attributes['tagid'];
        return Cache::remember($cacheId, SHORT_CACHE_TIME, function(){
            return DB::table($this->dbPre.'enewstagsdata')
                ->select('id')
                ->where('tagid', $this->attributes['tagid'])
                ->get()
                ->keyBy('id')
                ->keys()
                ->toArray();
        });
    }
}