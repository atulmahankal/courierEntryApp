<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		try {
			if (!Schema::hasTable('couriers')) {
				Schema::create('couriers', function (Blueprint $table) {
					$table->id();
					$table->timestamp('date');
					$table->string('direction');
					$table->string('type');
					$table->string('party');
					$table->string('courier_name');
					$table->string('courier_contact');
					$table->string('person_name')->nullable();;
					$table->string('person_contact')->nullable();;
					$table->longText('remarks')->nullable();;
					$table->string('status')->nullable();;
					$table->timestamps();
				});
			}
		} catch (Throwable $ex) {
			Schema::dropIfExists('couriers');
			dd("--- ERROR: ". $ex->getMessage());
		}
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('couriers');
    }
};
