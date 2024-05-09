<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GegenstandLager extends Model
{
	use HasFactory,
		SoftDeletes;

	protected $primaryKey = 'gegenstand_lager_id';

	protected $table = 'gegenstaende_lager';

	public function scopeIsLagerId(Builder $query, int $lager_id): Builder
	{
		return $query->where('lager_id', $lager_id);
	}

	public function getPlatzImLager()
	{
		$anzahl = 1;
		$lager = $this->lager;
		$gegenstand = $this->gegenstand;

		if(!$gegenstand->ist_stapelbar)
		{
			$anzahl = $this->anzahl;
		}
		else
		{
			$stack_anzahl = $this->gegenstand->gegenstandStack($lager->typ_id)
				->first();
			if(is_null($stack_anzahl))
			{
				return $this->anzahl;
			}
			$stack_anzahl = $stack_anzahl->anzahl;
			$anzahl = ceil($this->anzahl / $stack_anzahl);
		}

		return $anzahl;
	}

	public function scopeIsGegenstandId(Builder $query, int $gegenstand_id): Builder
	{
		return $query->where('gegenstand_id', $gegenstand_id);
	}

	public function gegenstand()
	{
		return $this->belongsTo(Gegenstand::class, 'gegenstand_id', 'gegenstand_id');
	}

	public function lager()
	{
		return $this->belongsTo(Lager::class, 'lager_id', 'lager_id');
	}
}
