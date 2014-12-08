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

	public static $edit_rules = array(
  );


	public function feeds() {
		return $this->hasMany('Feed');
	}

  public function categories() {
    return $this->hasMany('Category');
  }

}
