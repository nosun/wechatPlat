<?php

namespace Share\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleCheck extends Model{

    protected $primaryKey = 'id';
    public $timestamps = false;

    public function __construct(array $attributes = [])
    {
        $this->table = config('cwzg.edbPrefix').'ecms_article_check';
        parent::__construct($attributes);
    }

}