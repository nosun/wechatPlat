<?php

namespace Share\BusinessModels;

use Share\Models\ArticleCheck as DbArticleCheck;

use Cache;
use DB;

class ArticleCheck extends Article{
    protected $id = null;
    protected $dbPre = null;

    public function __construct($id)
    {
        $this->id = $id;
        $this->dbPre = config('cwzg.edbPrefix');
        $cacheId = 'article-model-'.$id;
        $this->model = Cache::remember($cacheId, CACHE_TIME, function()use($id){
            return DbArticleCheck::find($id);
        });

        if($this->model){
            $this->model->title = stripslashes($this->model->title);
            $this->model->ftitle = stripslashes($this->model->ftitle);
            $this->model->author = $this->model->author ? $this->model->author : '佚名';
            $enewsclass = $this->getArticleClass();
            $url = '/'.$enewsclass->classpath.'/'. $this->model->newspath.'/'. $this->model->filename.$enewsclass->filetype;
            $this->attributes['url'] = url($url);
        }
    }

    protected function getArticleData()
    {
        $cacheId = 'article-data-'.$this->id;
        return Cache::remember($cacheId, CACHE_TIME, function(){
            $result = [];
            if($this->model){
                $sideTable = $this->dbPre.'ecms_article_check_data';
                $result = (array) DB::table($sideTable)->where('id', $this->id)->get()->toArray()[0];
                $result['newstext'] = stripslashes($result['newstext']);
            }
            return $result;
        });
    }
}