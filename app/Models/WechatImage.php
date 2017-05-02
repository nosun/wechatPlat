<?php

namespace Share\Models;

use Illuminate\Database\Eloquent\Model;

class WechatImage extends Model
{

	protected $table = 'wx_images';
	protected $fillable = [
		'media_id','name','path','url','created_at','updated_at'
	];

}
