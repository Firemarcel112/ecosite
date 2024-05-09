<?php

use App\Models\LagerTyp;
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
		Schema::create("lagertypen", function (Blueprint $table) {
			$table->integerIncrements('lagertyp_id');
			$table->string('name');
			$table->integer('platz');
			$table->timestamps();
			$table->softDeletes();
		});

		$create_lager = [
			[
				'lagertyp_id' => 1,
				'name' => 'Bauholzlager (Groß)',
				'platz' => 100,
			],
			[
				'lagertyp_id' => 2,
				'name' => 'Lager (Groß)',
				'platz' => 25,
			],
			[
				'lagertyp_id' => 3,
				'name' => 'Lager (Mittel)',
				'platz' => 9,
			],
			[
				'lagertyp_id' => 4,
				'name' => 'Lager (Winzig)',
				'platz' => 4,
			],
			[
				'lagertyp_id' => 5,
				'name' => 'Holzkiste',
				'platz' => 16,
			],
			[
				'lagertyp_id' => 6,
				'name' => 'Eisschrank',
				'platz' => 16,
			],
			[
				'lagertyp_id' => 7,
				'name' => 'Hölzernes Vorratssilo',
				'platz' => 50,
			],
			[
				'lagertyp_id' => 8,
				'name' => 'Kommode',
				'platz' => 16,
			],
			[
				'lagertyp_id' => 9,
				'name' => 'Außenpostennetz',
				'platz' => 16,
			],
		];

		foreach($create_lager as $create)
		{
			LagerTyp::create($create);
		}
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('lagertypen');
	}
};
