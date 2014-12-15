<?php

class UserController extends AuthorizedController {

	/**
	 * Display a listing of the resource.
	 * GET /user
	 *
	 * @return Response
	 */
	public function index() {
		$user= $this->user;
		return View::make('front.user.index', compact('user'));
	}

	public function store() {
		$validator = Validator::make(Input::all(), User::$settings_rules);
    if ($validator->fails()) {
      return Redirect::back()->withInput()
      											 ->withErrors($validator);
    }

    $this->user->articleCacheMax = Input::get('cache_max');
    $this->user->save();

    return Redirect::back()->with('success', Lang::get('user.success'));
	}


}