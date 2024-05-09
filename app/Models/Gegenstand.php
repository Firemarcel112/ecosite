<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Gegenstand extends Model
{
	use HasFactory,
		SoftDeletes;

	protected $primaryKey = 'gegenstand_id';

	protected $table = 'gegenstaende';

	public function getEingelagertGesamt() : int
	{
		$gegenstaende = $this->gegenstandLager;
		$eingelagert_anzahl = 0;
		foreach ($gegenstaende as $eingelagert) {
			$eingelagert_anzahl += $eingelagert->anzahl;
		};
		return $eingelagert_anzahl;
	}

	public function scopeIstNichtStapelbar(Builder $query): Builder
	{
		return $query->where('ist_stapelbar', 0);
	}

	public function scopeIstStapelbar(Builder $query): Builder
	{
		return $query->where('ist_stapelbar', 1);
	}

	public function gegenstandStack(int $lagertyp_id)
	{
		return $this->hasMany(GegenstandStack::class, 'gegenstand_id', 'gegenstand_id')
			->isLagerTypId($lagertyp_id);
	}


	public function gegenstandLager()
	{
		return $this->hasMany(GegenstandLager::class, 'gegenstand_id', 'gegenstand_id');
	}
}
