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
		Schema::create('aufgaben', function (Blueprint $table) {
			$table->integerIncrements('aufgaben_id');
			$table->string('titel');
			$table->string('beschreibung');
			$table->integer('author_id');
			$table->integer('zugewiesen_id');
			$table->tinyInteger('status')
				->default(0)
				->comment('0 = offen, 1 = In Arbeit, 2 = Erledigt');
			$table->tinyInteger('priorisierung')
				->default(0);
			$table->timestamp('erledigt_am')->nullable();

			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('aufgaben');
	}
};
