<?php

namespace Share\BusinessModels;

use Share\Models\Copyfrom as DbCopyfrom;
use Share\Searches\InfoTypeSearch;

use Cache;


class Copyfrom extends Model{
    private $id = null;
    private $dbPre = null;

    public function __construct($id)
    {
        $this->id = $id;
        $this->dbPre = config('cwzg.edbPrefix');
        $cacheId = 'copyfrom-model-'.$id;
        $this->model = Cache::remember($cacheId, CACHE_TIME, function()use($id){
            return DbCopyfrom::find($id);
        });
        if($this->model){
            $this->infotype = '';
            $infoType = InfoTypeSearch::instance()->find($this->ttid);
            if($infoType){
                $this->infotype = $infoType->tname;
            }
        }
    }
}