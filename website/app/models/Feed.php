<?php

class Feed extends Eloquent {
	
	protected $guarded = array();
	public static $rules = array();

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
