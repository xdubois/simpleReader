<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateArticlesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('articles', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('guid')->nullable();
			$table->string('title')->nullable();
			$table->string('creator')->nullable();
			$table->string('link')->nullable();
			$table->string('content')->nullable();
			$table->timestamp('pubDate')->nullable();
			$table->boolean('favorite')->default(0);
			$table->boolean('unread')->nullable();
			
			$table->integer('feed_id')->unsigned();
			$table->foreign('feed_id')->references('id')->on('feeds');
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('articles', function(Blueprint $table) {
			$table->dropForeign('articles_feed_id_foreign');
		});
		
		Schema::drop('articles');
	}

}
