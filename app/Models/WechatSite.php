<?php

namespace Share\Models;

use Illuminate\Database\Eloquent\Model;

class WechatSite extends Model
{
    public $table = 'wx_site';

    protected $fillable = ['name','biz','type','logo','desc','uid','reg_type','reg_owner','reg_time', 'fans_number'];

}
