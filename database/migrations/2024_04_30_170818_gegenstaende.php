<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::create("gegenstaende", function (Blueprint $table) {
			$table->integerIncrements('gegenstand_id');
			$table->string('name');
			$table->tinyInteger('ist_stapelbar')
				->default(1);
			$table->timestamps();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('gegenstaende');
	}
};
