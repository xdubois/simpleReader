<?php
class UserTableSeeder extends Seeder {

	public function run() {

    $permissions = ['superuser' => 1];
    try { //create admin group
      $adminGroup = Sentry::getGroupProvider()->create(array(
        'name' => 'lol',
        'permissions' => $permissions,
        ));
    }
    catch(Exception $e) {}

    try {
      $user = Sentry::getUserProvider()->create(array(
        'email'    => 'admin@simplereader.com',
        'password' => 'admin',
        'permissions' => $permissions,
        'synchroCode' => Str::random(8),
        ));

      // activate user
      $activationCode = $user->getActivationCode();
      $user->attemptActivation($activationCode);

      $user->addGroup($adminGroup);
    }
    catch(Exception $e) {}

  }


}