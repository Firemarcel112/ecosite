<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GegenstandStack extends Model
{
	use HasFactory;

	protected $primaryKey = 'gegenstand_stack_id';

	protected $table = 'gegenstaende_stack';

	public function scopeIsLagerTypId(Builder $query, int $lagertyp_id)
	{
		return $query->where('lagertyp_id', $lagertyp_id);
	}

	public function scopeIsGegenstandId(Builder $query, int $gegenstand_id)
	{
		return $query->where('gegenstand_id', $gegenstand_id);
	}

	public function lagertyp()
	{
		return $this->hasOne(LagerTyp::class, 'lagertyp_id', 'lagertyp_id');
	}

	public function gegenstand()
	{
		return $this->hasOne(Gegenstand::class, 'gegenstand_id', 'gegenstand_id');
	}
}
