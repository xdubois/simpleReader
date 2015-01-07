<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	//
});


App::after(function($request, $response)
{
  //
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

// Route::filter('auth', function()
// {
// 	if (Auth::guest())
// 	{
// 		if (Request::ajax())
// 		{
// 			return Response::make('Unauthorized', 401);
// 		}
// 		else
// 		{
// 			return Redirect::guest('login');
// 		}
// 	}
// });


Route::filter('auth', function() {
  // Check if the user is logged in
  if ( ! Sentry::check()) {

  	if (Request::ajax()) {
     return Response::make('Unauthorized', 401);
   }
   
   Session::put('loginRedirect', Request::url());
   return Redirect::route('signin');
 }
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

Route::filter('ajax.request', function() {
  if (!Request::ajax()) {
   return Response::make('Unauthorized', 401);
 }

});


/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function() {
  $request_token = Request::header('X-CSRF-Token');
  $token = Request::ajax() ? (!empty($request_token) ? $request_token : Input::get('_token')) : Input::get('_token');

  if (Session::token() !== $token) {
    throw new Illuminate\Session\TokenMismatchException;
  }
});


//View composer
View::composer(['front.feeds.*', 'front.articles.*', 'front.home', 'front.user.*', 'front.category.*'], function($view) {
  if (Sentry::check()) {
    $user = Sentry::getUSer();
    $navbar = $user->renderMenu();
    $view->with('navbar', $navbar);
  }
  else {
    $view->with('navbar', null); 
  }
});


//Syntara
View::composer('syntara::layouts.dashboard.master', function($view) {
    $view->with('siteName', 'SimpleReader');
});


