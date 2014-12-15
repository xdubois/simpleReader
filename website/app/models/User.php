<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Cartalyst\Sentry\Users\Eloquent\User as SentryUserModel;

class User extends SentryUserModel implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	public static $signup_rules = [
    'email'      => 'required|email|unique:users',
    'password'   => 'required|between:6,32',
    'password_confirm'   => 'required|between:6,32|same:password',
  ];

	public static $settings_rules = array(
    'cache_max' => 'required|numeric'
  );


	public function feeds() {
		return $this->hasMany('Feed');
	}

  public function categories() {
    return $this->hasMany('Category');
  }

  public function renderMenu() {
  
    $counter = $this->feeds()
    ->leftJoin('categories', 'categories.id', '=', 'feeds.category_id')
    ->join('articles', 'articles.feed_id', '=', 'feeds.id')
    ->select(DB::raw('count(articles.id) as total, COALESCE(categories.name, "subscriptions") AS name, categories.id'))
    ->whereNull('articles.unread')
    ->where('articles.favorite', FALSE)
    ->orWhere('articles.unread', TRUE)
    ->groupBy('categories.name')
    ->orderBy('categories.name', 'DESC')
    ->lists('total', 'name');

    $counter['total_unread'] = 0;
    foreach ($counter as $count['feeds']) {
      $counter['total_unread'] += $count['feeds'];
    }

    $counter['favorite'] = $this->feeds()
    ->join('articles', 'articles.feed_id', '=', 'feeds.id')
    ->select(DB::raw('count(articles.id) as total'))
    ->where('articles.favorite', true)
    ->first()->total; 
   

    $counter['feeds'] = $this->feeds()
    ->join('articles', 'articles.feed_id', '=', 'feeds.id')
    ->select(DB::raw('count(articles.id) as total, feeds.id'))
    ->where('articles.favorite', FALSE)
    ->whereNull('articles.unread')
    ->orWhere('articles.unread', TRUE)
    ->groupBy('feeds.id')
    ->orderBy('feeds.id', 'DESC')
    ->lists('total', 'id');

    $feeds = $this->feeds()->whereNull('category_id')->get();
    $subscriptions['subscriptions'] = $feeds;
    $categories = $this->categories()->get();
    foreach ($categories as $category) {
      $feeds = $category->feeds()->get();
      if (!$feeds->isEmpty())
        $subscriptions[$category->name] = $feeds;
    }
    return View::make('front.partial.nav', compact('subscriptions', 'counter'))->render();
  }

}
