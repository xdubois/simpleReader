<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', ['as' => 'home', 'uses' => 'ArticleController@index']);

Route::get('/articles', 'ArticleController@show');
Route::get('/articles/{id}/{filter?}/', ['as' => 'article.view', 'uses' => 'ArticleController@show']);

Route::group(array('prefix' => 'auth'), function() {
  # Login
  Route::get('signin', array(
    'as' => 'signin',
    'uses' => 'AuthController@signin')
  );
  Route::post('signin', 'AuthController@login');
  # Register
  Route::get('signup', array(
    'as' => 'signup',
    'uses' => 'AuthController@signup')
  );
  Route::post('signup', 'AuthController@store');
  # Account Activation
  Route::get('activate/{activationCode}', array(
    'as' => 'activate',
    'uses' => 'AuthController@activate')
  );
  # Forgot Password
  Route::get('forgot-password', array(
    'as' => 'forgot-password',
    'uses' => 'AuthController@forgotPassword')
  );
  Route::post('forgot-password', 'AuthController@sendForgotPassword');
  # Forgot Password Confirmation
  Route::get('forgot-password/{passwordResetCode}', array(
    'as' => 'forgot-password-confirm',
    'uses' => 'AuthController@confirmForgotPassword')
  );
  Route::post('forgot-password/{passwordResetCode}', 'AuthController@chooseNewPassword');
  # Logout
  Route::get('logout', array(
    'as' => 'logout',
    'uses' => 'AuthController@logout')
  );
});


Route::group(array('prefix' => 'feed'), function() {
  Route::get('/', ['as' => 'feed.index', 'uses' => 'FeedController@index']);
  Route::get('/destroy/{id}', ['as' => 'feed.destroy', 'uses' => 'FeedController@destroy']);
  Route::post('store', ['as' => 'feed.store', 'uses' => 'FeedController@store']);
});

Route::group(array('prefix' => 'user'), function() {
  Route::get('/', ['as' => 'user.index', 'uses' => 'UserController@index']);
  Route::post('/store', ['as' => 'user.store', 'uses' => 'UserController@store']);
});

Route::group(array('prefix' => 'category'), function() {
  Route::get('destroy/{id}', ['as' => 'category.destroy', 'uses' => 'CategoryController@destroy']);
  Route::post('store', ['as' => 'category.store', 'uses' => 'CategoryController@store']);
});

//Ajax request
Route::group(array('prefix' => 'ajax', 'before' => 'ajax.request'), function() {
 Route::post('update-category', ['as' => 'ajax.update.category', 'uses' => 'CategoryController@update']);
 Route::post('toggle-read', ['as' => 'ajax.toggle.read', 'uses' => 'ArticleController@toggleRead']);
 Route::post('toggle-favorite', ['as' => 'ajax.toggle.favorite', 'uses' => 'ArticleController@toggleFavorite']);
 Route::post('set-read', ['as' => 'ajax.article.read', 'uses' => 'ArticleController@setRead']);
 Route::post('update-category-name', ['as' => 'ajax.update.category.name', 'uses' => 'ArticleController@updateCategoryName']);
});
