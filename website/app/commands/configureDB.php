<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class configureDB extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'db:configure';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Configure database';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire() {
		$this->configureDB();
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

}
