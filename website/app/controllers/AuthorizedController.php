<?php

class AuthorizedController extends BaseController {

  /**
   * Connected user
   * @var User
   */
  protected $user;

  /**
   * Whitelisted auth routes.
   *
   * @var array
   */
  protected $whitelist = array();

  /**
   * Initializer.
   *
   * @return void
   */
  public function __construct() {
    parent::__construct();
    // Apply the auth filter
    $this->beforeFilter('auth', array('except' => $this->whitelist));
    // Grab the user
    $this->user = Sentry::getUser();
  }
}
