<?php
class UserTableSeeder extends Seeder {

	public function run() {

    $permissions = ['superuser' => 1];
    try { //create admin group
      $adminGroup = Sentry::getGroupProvider()->create(array(
        'name' => 'admin',
        'permissions' => $permissions,
        ));
    }
    catch(Exception $e) {}

  }


}