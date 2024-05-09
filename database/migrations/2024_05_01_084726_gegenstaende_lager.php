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
		Schema::create('gegenstaende_lager', function (Blueprint $table) {
			$table->integerIncrements('gegenstand_lager_id');
			$table->integer('lager_id');
			$table->integer('gegenstand_id');
			$table->integer('anzahl');
			$table->timestamps();
			$table->softDeletes();

			// $table->unique(['gegenstand_id', 'lager_id']);
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('gegenstaende_lager');
	}
};
