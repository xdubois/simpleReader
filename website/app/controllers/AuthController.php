<?php

class AuthController extends BaseController {

  /**
   * Account sign in.
   *
   * @return View
   */
  public function signin() {
    // Is the user logged in?
    if (Sentry::check()) {
      return Redirect::route('home');
    }
    // Show the page
    return View::make('front.auth.signin');
  }

  /**
   * Account sign in form processing.
   *
   * @return Redirect
   */
  public function login() {
    $rules = array(
      'email' => 'required|email',
      'password' => 'required|between:3,32',
    );
    $validator = Validator::make(Input::all(), $rules);
    if ($validator->fails()) {
      return Redirect::back()->withInput()->withErrors($validator);
    }

    try {
      Sentry::authenticate(Input::only('email', 'password'), Input::get('remember-me', 0));
      $redirect = Session::get('loginRedirect', 'users');
      Session::forget('loginRedirect');

      return Redirect::to($redirect)->with('success', Lang::get('auth.signin.success'));
    }
    catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
      $this->messageBag->add('email', Lang::get('auth.account_not_found'));
    }
    catch (Cartalyst\Sentry\Users\UserNotActivatedException $e) {
      $this->messageBag->add('email', Lang::get('auth.account_not_activated'));
    }
    catch (Cartalyst\Sentry\Throttling\UserSuspendedException $e) {
      $this->messageBag->add('email', Lang::get('auth.account_suspended'));
    }
    catch (Cartalyst\Sentry\Throttling\UserBannedException $e) {
      $this->messageBag->add('email', Lang::get('auth.account_banned'));
    }

    return Redirect::back()->withInput()->withErrors($this->messageBag);
  }

  /**
   * Account sign up.
   *
   * @return View
   */
  public function signup() {
    // Is the user logged in?
    if (Sentry::check()) {
      return Redirect::route('home');
    }

    return View::make('front.auth.signup');
  }

  /**
   * Account sign up form processing.
   *
   * @return Redirect
   */
  public function store() {
    $inputs = array_except(Input::all(), array('_method'));
    $validator = Validator::make($inputs, User::$signup_rules);
    
    if ($validator->fails()) {
      return Redirect::back()->withInput()->withErrors($validator);
    }
    try {

      // Register the user
      $user = Sentry::register(array(
        'email' => Input::get('email'),
        'password' => Input::get('password'),
        'activated' => TRUE,
        'synchroCode' => Str::random(8),
      ));

      Sentry::authenticate(Input::only('email', 'password'), 0);

      return Redirect::route('signin')->with('success', Lang::get('auth.signup.success'));
    }
    catch (Cartalyst\Sentry\Users\UserExistsException $e) {
      $this->messageBag->add('email', Lang::get('auth.account_already_exists'));
    }

    return Redirect::back()->withInput()->withErrors($this->messageBag);
  }

  /**
   * User account activation page.
   *
   * @param  string  $actvationCode
   * @return
   */
  public function activate($activationCode = null) {
    // Is the user logged in?
    if (Sentry::check()) {
      return Redirect::route('account');
    }

    try {
      $user = Sentry::getUserProvider()->findByActivationCode($activationCode);
      if ($user->attemptActivation($activationCode)) {
        return Redirect::route('signin')->with('success', Lang::get('auth.activate.success'));
      }

      $error = Lang::get('auth.activate.error');
    }
    catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
      $error = Lang::get('auth.activate.error');
    }

    return Redirect::route('signin')->with('error', $error);
  }

  /**
   * Forgot password page.
   *
   * @return View
   */
  public function forgotPassword() {
    // Show the page
    return View::make('front.auth.forgot-password');
  }

  /**
   * Forgot password form processing page.
   *
   * @return Redirect
   */
  public function sendForgotPassword() {
    $rules = array(
      'email' => 'required|email',
    );

    $validator = Validator::make(Input::all(), $rules);
    if ($validator->fails()) {
      return Redirect::route('forgot-password')->withInput()->withErrors($validator);
    }

    try {
      $user = Sentry::getUserProvider()->findByLogin(Input::get('email'));
      $data = array(
        'user' => $user,
        'forgotPasswordUrl' => URL::route('forgot-password-confirm', $user->getResetPasswordCode()),
      );

      Mail::send('emails..auth.forgot-password', $data, function($m) use ($user) {
                $m->to($user->email, $user->first_name . ' ' . $user->last_name);
                $m->subject('Account Password Recovery');
              });
    }
    catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
      // Even though the email was not found, we will pretend
      // we have sent the password reset code through email,
      // this is a security measure against hackers.
    }

    return Redirect::route('forgot-password')->with('success', Lang::get('auth.forgot-password.success'));
  }

  /**
   * Forgot Password Confirmation page.
   *
   * @param  string  $passwordResetCode
   * @return View
   */
  public function confirmForgotPassword($passwordResetCode = null) {
    try {
      $user = Sentry::getUserProvider()->findByResetPasswordCode($passwordResetCode);
    }
    catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
      return Redirect::route('forgot-password')->with('error', Lang::get('auth.account_not_found'));
    }

    return View::make('front.auth.forgot-password-confirm');
  }

  /**
   * Forgot Password Confirmation form processing page.
   *
   * @param  string  $passwordResetCode
   * @return Redirect
   */
  public function chooseNewPassword ($passwordResetCode = null) {
    $rules = array(
      'password' => 'required',
      'password_confirm' => 'required|same:password'
    );

    $validator = Validator::make(Input::all(), $rules);
    if ($validator->fails()) {
      return Redirect::route('forgot-password-confirm', $passwordResetCode)->withInput()->withErrors($validator);
    }

    try {
      $user = Sentry::getUserProvider()->findByResetPasswordCode($passwordResetCode);
      // Attempt to reset the user password
      if ($user->attemptResetPassword($passwordResetCode, Input::get('password'))) {
        // Password successfully reseted
        return Redirect::route('signin')->with('success', Lang::get('auth.forgot-password-confirm.success'));
      }
      else {
        return Redirect::route('signin')->with('error', Lang::get('auth.forgot-password-confirm.error'));
      }
    }
    catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
      return Redirect::route('forgot-password')->with('error', Lang::get('auth.account_not_found'));
    }
  }

  /**
   * Logout page.
   *
   * @return Redirect
   */
  public function logout() {
    Sentry::logout();

    return Redirect::route('home')->with('success', 'You have successfully logged out!');
  }

}
