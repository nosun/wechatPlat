<?php

namespace Share\Models;

use Illuminate\Database\Eloquent\Model;

class InfoType extends Model
{
	protected $primaryKey = 'typeid';
	public $timestamps = false;

	public function __construct(array $attributes = [])
	{
		$this->table = config('cwzg.edbPrefix').'enewsinfotype';
		parent::__construct($attributes);
	}
}
