<?php

namespace Share\BusinessModels;

use Share\Models\Article;
use Share\Models\Author as DbAuthor;
use Share\ModelHelpers\EnewsclassHelper;
use Share\Searches\ArticleSearch;

use Cache;
use DB;

class Author extends Model{
    private $id = null;

    public function __construct($id)
    {
        $this->id = $id;
        $cacheId = 'author-model-'.$id;
        $this->model = Cache::remember($cacheId, CACHE_TIME, function()use($id){
            return DbAuthor::find($id);
        });

        if($this->model){
            $url = '/column/'. $this->model->filename.'.html';
            $this->attributes['url'] = url($url);
        }
    }

    private function getAuthorData()
    {
        $cacheId = 'author-data-'.$this->id;
        return Cache::remember($cacheId, CACHE_TIME, function(){
            $result = null;
            if($this->model){
                $sideTable = config('cwzg.edbPrefix').'ecms_author_data_'.$this->model->stb;
                $result = (array) DB::table($sideTable)->where('id', $this->id)->first();
            }
            return $result;
        });
    }

    private function getAuthorStatisticsData(){
        $cacheId = 'author-statistics-'.$this->id;
        return Cache::remember($cacheId, CACHE_TIME, function(){
            $db = ArticleSearch::instance()->author($this->title);
            $statistics = [
                'articlenum' => $db->count(),
                'articleplnum' => $db->sum('plnum'),
                'articlepclicknum' => $db->sum('onclick'),
            ];

            $statistics['articlepraisenum'] = $db->getDb()->join(config('cwzg.edbPrefix').'ecmsextend_mood as m', 'a.id', '=', 'm.id')->sum('mood6');
            return $statistics;
        });
    }

    protected function asynLoad1(){
        $authorData = $this->getAuthorData();
        if($authorData){
            $this->attributes = array_merge($this->attributes, $authorData);
        }
    }

    protected function asynLoad2(){
        $statistics = $this->getAuthorStatisticsData();
        if(!empty($statistics)){
            $this->attributes = array_merge($this->attributes, $statistics);
        }
    }

    public function getAuthorClass(){
        return EnewsclassHelper::find($this->classid);
    }

    public function getArticleIds(){
        return ArticleSearch::instance()->author($this->title)->getIds();
    }

    public function getArticleCount(){
        return count($this->getArticleIds());
    }
}