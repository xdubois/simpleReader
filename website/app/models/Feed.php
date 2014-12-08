<?php

class Feed extends Eloquent {
	
	protected $guarded = array();

	public function getRules() {
		return [];
		return [
			'url' => 'unique:feeds,url,NULL,id,user_id,'. Sentry::getuser()->id .''
		];
	}

	public function category() {
		return $this->belongsTo('Category');
	}

	public function user() {
		return $this->belongsTo('User');
	}

	public function articles() {
		return $this->hasMany('Article');
	}
}
