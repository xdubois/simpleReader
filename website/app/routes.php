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

//Home route
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
  Route::get('/update/{id?}', ['as' => 'feed.update', 'uses' => 'FeedController@update']);
  Route::post('store', ['as' => 'feed.store', 'uses' => 'FeedController@store']);
});

Route::group(array('prefix' => 'user'), function() {
  Route::get('/', ['as' => 'user.index', 'uses' => 'UserController@index']);
  Route::post('/store', ['as' => 'user.store', 'uses' => 'UserController@store']);
});

Route::group(array('prefix' => 'category'), function() {
  Route::get('destroy/{id}', ['as' => 'category.destroy', 'uses' => 'CategoryController@destroy']);
  Route::get('edit/{id}', ['as' => 'category.edit', 'uses' => 'CategoryController@edit']);
  Route::post('store', ['as' => 'category.store', 'uses' => 'CategoryController@store']);
  Route::post('store/{id}', ['as' => 'category.update', 'uses' => 'CategoryController@update']);
});

//webcron
Route::get('webcron/{token}', ['as' => 'feed.update.token', 'uses' => 'FeedController@webCronUpdate']);

//Ajax request
Route::group(array('prefix' => 'ajax', 'before' => 'ajax.request'), function() {
 Route::post('update-category', ['as' => 'ajax.update.category', 'uses' => 'CategoryController@updateFeedCategory']);
 Route::post('toggle-read', ['as' => 'ajax.toggle.read', 'uses' => 'ArticleController@toggleRead']);
 Route::post('toggle-favorite', ['as' => 'ajax.toggle.favorite', 'uses' => 'ArticleController@toggleFavorite']);
 Route::post('set-read', ['as' => 'ajax.article.read', 'uses' => 'ArticleController@setRead']);
 Route::post('update-category-name', ['as' => 'ajax.update.category.name', 'uses' => 'ArticleController@updateCategoryName']);
 Route::post('set-articles-read/{id}', ['as' => 'ajax.set.articles.read', 'uses' => 'FeedController@setAllArticleRead']);
 Route::post('item-click-count', ['as' => 'ajax.item.click', 'uses' => 'UserController@updateClickCounter']);
 Route::post('update-feed-name', ['as' => 'ajax.update.feed.name', 'uses' => 'FeedController@updateFeedName']);
});


// syntra overrided route
/**
 * Loggued routes with permissions
 */
Route::group(array('before' => 'basicAuth|hasPermissions', 'prefix' => Config::get('syntara::config.uri')), function() {
    /**
     * User routes
     */
    Route::get('users', array(
        'as' => 'listUsers',
        'uses' => 'CustomUserController@getIndex')
    );
    Route::delete('user/{userId}', array(
        'as' => 'deleteUsers',
        'uses' => 'CustomUserController@delete')
    );
    Route::post('user/new', array(
        'as' => 'newUserPost',
        'uses' => 'CustomUserController@postCreate')
    );
    Route::get('user/new', array(
        'as' => 'newUser',
        'uses' => 'CustomUserController@getCreate')
    );
    Route::get('user/{userId}', array(
        'as' => 'showUser',
        'uses' => 'CustomUserController@getShow')
    );
    Route::put('user/{userId}', array(
        'as' => 'putUser',
        'uses' => 'CustomUserController@putShow')
    );
    Route::put('user/{userId}/activate', array(
        'as' => 'putActivateUser',
        'uses' => 'CustomUserController@putActivate')
    );
});