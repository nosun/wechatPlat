<?php

namespace Share\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleData extends Model{

    protected $table = "wx_article_data";
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

}