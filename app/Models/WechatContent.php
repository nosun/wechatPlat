<?php

namespace Share\Models;

use Illuminate\Database\Eloquent\Model;

class WechatContent extends Model
{
	protected $table = 'wx_contents';
	protected $fillable = [
			'title','media_id','idx','keyword','author','thumb_url','thumb_media_id','template','digest','content','note',
			'content_source_url','url','show_cover_pic','original','copyright','editor','uid','created_at','updated_at'
	];

	public function news(){
		return $this->belongsTo('Share\Models\WechatContent','media_id','media_id');
	}

	public function convertArticle(){
		return [
			'id' => $this->id,
			'type' => 'content',
			'fid' => 'content-'.$this->id,
			'media_id' => $this->media_id,
			'idx' => $this->idx,
			'title' => $this->title,
			'titlepic' => $this->thumb_url,
			'author' => $this->author,
			'smalltext' => $this->digest,
			'newstext' => $this->content,
			'note' => $this->note,
			'titleurl' => $this->content_source_url,
		];
	}

}
