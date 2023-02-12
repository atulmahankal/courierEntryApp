<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Laravel\Fortify\Fortify;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function (Blueprint $table) {
			$table->string('profile_photo_path', 2048)
				->after('remember_token')
				->nullable();
			$table->timestamp('last_login_time')
				->after('profile_photo_path')
				->nullable();
			$table->integer('isAdmin')
				->after('password')
				->default(0);
			$table->string('last_login_ip', 15)
				->after('last_login_time')
				->nullable();
			$table->integer('status')
				->after('last_login_ip')
				->default(1);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users', function (Blueprint $table) {
			$table->dropColumn([
				'profile_photo_path',
				'last_login_time',
				'last_login_ip',
				'status'
			]);
		});
	}
};
