<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class InstallCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var	string
	 */
	protected $name = 'app:install';

	/**
	 * The console command description.
	 *
	 * @var	string
	 */
	protected $description = 'Install the app';


	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
	}


   /**
 * Execute the console command.
 *
 * @return void
 */
  public function fire() {
    $this->comment('=====================================');
    $this->comment('');
    $this->info('Preparing your application..');
    $this->comment('');
    $this->comment('=====================================');
    $this->comment('');
    // Generate the Application Encryption key
    // $this->call('key:generate');

    $this->configureDB();

    // Run the Sentry Migrations
    $this->call('migrate', array('--package' => 'cartalyst/sentry'));
    $this->call('migrate', array('--package' => 'mrjuliuss/syntara'));
    // Run the Migrations
    $this->call('migrate');

    //DB seeding
    $this->call('db:seed');

    //create default user
    $this->createDefaultUser();

    $this->info('installation complete !');
  }

  private function configureDB() {
    $this->info('Configure database');
    $settings['DB_HOST'] = $this->ask('host:');
    $settings['DB_NAME'] = $this->ask('database:');
    $settings['DB_USERNAME'] = $this->ask('username:');
    $settings['DB_PASSWORD'] = $this->secret('password:');
    $settings['DB_PASSWORD'] = is_null($settings['DB_PASSWORD']) ? '' : $settings['DB_PASSWORD'];
    $settings = var_export($settings, 1);
    File::put(app_path() .'/../.env.local.php' ,  "<?php\n return $settings ;");
  }

  private function createDefaultUser() {
    $this->info('Create admin user');
    $email = $this->ask('Email (work as username):');
    $password = $this->secret('password:');

    try {
      $user = Sentry::getUserProvider()->create(array(
        'email'    => $email,
        'password' => $password,
        'synchroCode' => Str::random(8),
        ));

      // activate user
      $activationCode = $user->getActivationCode();
      $user->attemptActivation($activationCode);
      $adminGroup = Sentry::findGroupByName('admin');
      $user->addGroup($adminGroup);
    }
    catch(Exception $e) {}

  }

}
