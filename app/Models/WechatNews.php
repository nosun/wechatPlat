<?php

namespace Share\Models;

use Illuminate\Database\Eloquent\Model;
use Share\Searches\WechatContentsSearch;
use Share\Models\WechatContent;
use Cache;

class WechatNews extends Model
{

	protected $table = 'wx_news';
	protected $fillable = [
		'media_id',
	];

	public function getContents(){
		return WechatContentsSearch::instance()->news($this)->orderBy('idx asc')->get();
	}

	public function nextIdx(){
		$idx = 1;
		$contents = $this->getContents();
		if(!empty($contents)){
			foreach($contents as $content){
				if($content->idx > $idx){
					$idx = $content->idx;
				}
			}
			$idx += 1;
		}
		return $idx;
	}


	public function deleteContents(){
		if(empty($this->media_id)){
			return false;
		}
		return WechatContent::where('media_id',$this->media_id)->delete();
	}
}
