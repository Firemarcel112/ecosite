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
		Schema::create('gegenstaende_stack', function(Blueprint $table)
		{
			$table->integerIncrements('gegenstand_stack_id');
			$table->unsignedInteger('lagertyp_id');
			$table->unsignedInteger('gegenstand_id');
			$table->integer('anzahl');

			$table->foreign('lagertyp_id')
				->references('lagertyp_id')
				->on('lagertypen');

			$table->foreign('gegenstand_id')
				->references('gegenstand_id')
				->on('gegenstaende');

			$table->unique(['lagertyp_id', 'gegenstand_id']);
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('gegenstaende_stack');
	}
};
