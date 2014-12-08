<?php

class Article extends Eloquent {
	protected $guarded = array();

	public static $rules = array();

	public function feed() {
		$this->belongsTo('Feed');
	}

  public function getDates() {
    return ['created_at', 'updated_at', 'pubDate'];
  }
}
