<?php

namespace Share\Searches;
use DB;
use Cache;

abstract class Search{
    protected $cache = true;
    protected $db;
    protected $attribute = [
        'filter'=>[],
        'where'=>[],
    ];

    protected function __construct($table, $primaryKey = 'id', $prefix = true)
    {
        if($prefix){
            $table = config('cwzg.edbPrefix').$table;
        }
        $this->attribute['table'] = $table;
        $this->attribute['primaryKey'] = $primaryKey;
        $this->resetDb();
    }

    public function resetDb(){
        unset($this->db);
        $this->db = DB::table($this->attribute['table']);
        $this->attribute = [
            'filter' => [],
            'where' => [],
            'table' =>  $this->attribute['table'],
            'primaryKey' =>  $this->attribute['primaryKey'],
        ];
    }

    public function filter($filter){
        if(is_array($filter)){
            $this->attribute['filter'][] = $filter;
            foreach($filter as $key => $value){
                if( strpos($key,  ' ')){
                    $arr = explode(' ', $key);
                    $field = $arr[0];
                    $op = $arr[1];
                    if($op == 'in'){
                        $this->db->whereIn($field, $value);
                    }else{
                        $this->db->where($field, $op, $value);
                    }
                }else{
                    $this->db->where($key, $value);
                }
            }
        }
        return $this;
    }

    public function where(){
        $args = func_get_args();
        $argNum = func_num_args();
        $this->attribute['where'][] = $args;

        if($argNum == 1 && is_array($args[0])){
            $this->db->where($args[0]);
        }elseif($argNum == 2){
            $this->db->where($args[0], $args[1]);
        }else{
            $this->db->where($args[0], $args[1], $args[2]);
        }
        return $this;
    }


    public function orderBy($orderBy){
        $this->attribute['orderby'] = $orderBy;
        $this->db->orderByRaw($orderBy);
        return $this;
    }

    public function page($page, $pageRow){
        $this->attribute['page'] = $page;
        $this->attribute['pageRow'] = $pageRow;
        $this->db->limit($pageRow)->skip( ($page-1)*$pageRow );
        return $this;
    }

    public function limit($limit){
        $this->attribute['limit'] = $limit;
        $this->db->limit($limit);
        return $this;
    }

    public function skip($skip){
        $this->attribute['skip'] = $skip;
        $this->db->skip($skip);
        return $this;
    }

    public function count(){
        if($this->cache){
            $cacheId = 'search-count-'.md5(json_encode($this->attribute));
            $count = Cache::remember($cacheId, SHORT_CACHE_TIME, function(){
                return $this->db->count();
            });
        }else{
            $count = $this->db->count();
        }
        return $count;
    }

    public function sum($column){
        if($this->cache){
            $cacheId = 'search-sum-'.$column.'-'.md5(json_encode($this->attribute));
            $sum = Cache::remember($cacheId, SHORT_CACHE_TIME, function()use($column){
                return $this->db->sum($column);
            });
        }else{
            $sum = $this->db->sum($column);
        }
        return $sum;

    }

    public function max($column){
        if($this->cache){
            $cacheId = 'search-max-'.$column.'-'.md5(json_encode($this->attribute));
            $max = Cache::remember($cacheId, SHORT_CACHE_TIME, function()use($column){
                return $this->db->max($column);
            });
        }else{
            $max = $this->db->max($column);
        }
        return $max;

    }

    public function avg($column){
        if($this->cache){
            $cacheId = 'search-avg-'.$column.'-'.md5(json_encode($this->attribute));
            $avg = Cache::remember($cacheId, SHORT_CACHE_TIME, function()use($column){
                return $this->db->average($column);
            });
        }else{
            $avg = $this->db->average($column);
        }
        return $avg;
    }

    public function getIds(){
        $primaryKey = $this->attribute['primaryKey'];
        if(strpos($this->attribute['primaryKey'], '.')){
            $keySeg = explode('.', $this->attribute['primaryKey']);
            $primaryKey = $keySeg[1];
        }
        if($this->cache){
            $cacheId = 'search-get-ids-'.md5(json_encode($this->attribute));
            $ids = Cache::remember($cacheId, SHORT_CACHE_TIME, function()use($primaryKey){
                return $this->db->select($this->attribute['primaryKey'])->get()->keyBy($primaryKey)->keys()->toArray();
            });
        }else{
            $ids = $this->db->select($this->attribute['primaryKey'])->get()->keyBy($primaryKey)->keys()->toArray();
        }
        $this->resetDb();
        return $ids;
    }

    public function whereIn($column, $values)
    {
        if(!isset($this->attribute['whereIn'])){
            $this->attribute['whereIn'] = [];
        }

        $this->db->whereIn($column, $values);

        $values[] = $column;
        $this->attribute['whereIn'][] = $values;
        return $this;
    }

    public function getDb(){
        return $this->db;
    }

    abstract public function get();

    abstract public function first();
}