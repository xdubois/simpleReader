<?php

class Article extends Eloquent {
	protected $guarded = array();

	public static $rules = array();

	public function feed() {
		$this->belongsTo('Feed');
	}
}
