<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UpdateUersTableAddParamsFields extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function(Blueprint $table) {
			$table->string('synchroCode');
			$table->integer('articleCacheMax')->default(10);
			$table->integer('aricleDownloaded')->nullable()->default(0);
			$table->integer('articleReaded')->nullable()->default(0);
			$table->integer('articleClicked')->nullable()->default(0);
			$table->dropColumn('last_name', 'first_name', 'username');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users', function(Blueprint $table) {
			$table->dropColumn('synchroCode','articleCacheMax', 'aricleDownloaded', 'articleReaded', 'articleClicked');
			$table->string('last_name');
			$table->string('first_name');
			$table->string('username');
		});
	}

}
