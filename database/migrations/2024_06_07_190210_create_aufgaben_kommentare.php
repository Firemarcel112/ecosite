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
		Schema::create('aufgaben_kommentare', function (Blueprint $table) {
			$table->integerIncrements('aufgaben_kommentar_id');
			$table->integer('aufgaben_id');
			$table->integer('author_id');
			$table->string('text');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('aufgaben_kommentare');
	}
};
