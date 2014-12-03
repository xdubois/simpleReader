<?php

class Category extends Eloquent {
	
	protected $guarded = array();
	protected $table = 'categories';

	public static $rules = array();


	public function feeds() {
		return $this->hasMany('Feed');
	}

	public function user() {
		return $this->belongsTo('User');
	}
}
