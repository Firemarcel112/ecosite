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
		Schema::create('lagerorte', function(Blueprint $table)
		{
			$table->increments('lagerort_id');
			$table->string('name');
			$table->timestamps();
			$table->softDeletes();

			$table->unique('name');
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('lagerorte');
	}
};
