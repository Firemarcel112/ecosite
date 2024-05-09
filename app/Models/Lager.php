<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lager extends Model
{
	use HasFactory,
		SoftDeletes;

	protected $primaryKey = 'lager_id';

	protected $table = 'lager';

	public static function getPlatzTotal(): int
	{
		$lagers = self::get();
		$maximaler_platz = 0;
		foreach ($lagers as $lager) {
			$maximaler_platz += $lager->typ->platz;
		};
		return $maximaler_platz;
	}

	public static function getPlatzVerfuegbarTotal(): int
	{
		$lagers = self::get();
		$platz_verfuegbar = 0;
		foreach ($lagers as $lager) {
			$platz_verfuegbar += $lager->getVerfuegbarerPlatz();
		};
		return $platz_verfuegbar;
	}

	public function getPlatzVerfuegbar(): int
	{
		$verfuegbarer_platz = $this->typ->platz;
		$belegter_platz = 0;
		foreach($this->gegenstaendeLager as $gegenstand_lager)
		{
			$belegter_platz += $gegenstand_lager->getPlatzImLager();
		}
		$verfuegbarer_platz -= $belegter_platz;

		return $verfuegbarer_platz;
	}

	public function getVerfuegbarerPlatz(): int
	{
		$maximaler_platz = $this->typ->platz;
		$belegter_platz = 0;
		foreach($this->gegenstaendeLager as $gegenstand_lager)
		{
			$belegter_platz += $gegenstand_lager->getPlatzImLager();
		}
		$platz = $maximaler_platz - $belegter_platz;
		return $platz;
	}

	public function ort()
	{
		return $this->hasOne(LagerOrt::class, 'lagerort_id', 'ort_id');
	}

	public function typ()
	{
		return $this->hasOne(LagerTyp::class, 'lagertyp_id', 'typ_id');
	}

	public function gegenstaendeLager()
	{
		return $this->hasMany(GegenstandLager::class, 'lager_id', 'lager_id');
	}
}
