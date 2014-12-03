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
			$table->integer('articleCacheMax')->default(50);
			$table->integer('aricleDownloaded')->nullable()->default(0);
			$table->integer('articleReaded')->nullable()->default(0);
			$table->integer('articleClicked')->nullable()->default(0);
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
		});
	}

}
