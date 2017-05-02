<?php

namespace Share\ModelHelpers;

use EasyWeChat\Foundation\Application;
use Share\Models\WechatContent;
use Share\Models\WechatNews;
use Share\Models\WechatImage;
use Carbon\Carbon;

class WechatContentModelHelper
{

	public static function getItemTime($item){

		return $item['content']['create_time'];
	}

	// save news when batch down load
	public static function saveNews($item){
		$news = WechatNews::firstOrNew(['media_id' => $item['media_id']]);
		$news->created_at = Carbon::createFromTimeStampUTC($item['update_time'])->toDateTimeString();
		$news->updated_at = Carbon::createFromTimeStampUTC($item['update_time'])->toDateTimeString();
		$news->save();
		$i = 1;
		foreach($item['content']['news_item'] as $news_item){
			$content = WechatContent::firstOrNew(['media_id' => $item['media_id'],'idx' => $i]);
			$news_item['created_at'] = Carbon::createFromTimeStampUTC($item['content']['create_time'])->toDateTimeString();
			$news_item['updated_at'] = Carbon::createFromTimeStampUTC($item['content']['update_time'])->toDateTimeString();
			$content->fill($news_item)->save();
			$i++;
		}
	}

	// save media image to database
	public static function saveImage($item){
		$image = WechatImage::firstOrNew(['media_id' => $item['media_id']]);
		$image->created_at = Carbon::createFromTimeStampUTC($item['update_time'])->toDateTimeString();
		$image->updated_at = Carbon::createFromTimeStampUTC($item['update_time'])->toDateTimeString();
		$image->name = $item['name'];
		$image->url  = $item['url'];
		$image->path = $item['path'];
		$image->save();
	}

	// save media image to disk
	public static function saveFile($image,$type){
		$basePath = 'd/file/p/wechat';
		$datePath = date('Ym',time());
		$name     = md5(time().rand(1000,9999)).'.'.$type;
		$dir     = $basePath.'/'.$datePath;
		$realDir = ECMS_PATH.$dir;
		$path     = $dir.'/'.$name;
		$realPath = ECMS_PATH.$path;

		if(!is_dir($realDir)){
		    mkdir($realDir,'0755',true);
		}

 	    file_put_contents($realPath,$image);

		return ['path'=> $path, 'real_path' => $realPath];
	}

	public static function getImageType($url){
		$pattern = '/(\.*)?wx_fmt=(\w+)/';
		preg_match($pattern,$url,$matches);
		if(isset($matches[2])){
           return $matches[2];
		}
		return false;
	}

}