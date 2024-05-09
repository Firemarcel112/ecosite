<?php

namespace App\Traits;

use App\Models\Gegenstand;
use App\Models\Lager;
use App\Models\GegenstandLager;
use Illuminate\Http\RedirectResponse;

trait LagerTrait
{
	public function einlagern(int $gegenstand_id, int $lager_id, int $anzahl): RedirectResponse
	{
		$gegenstand_lager = GegenstandLager::isLagerId($lager_id)
			->isGegenstandId($gegenstand_id)
			->firstOrNew();
		$lager = Lager::findOrFail($lager_id);
		$gegenstand = Gegenstand::findOrFail($gegenstand_id);
		$verfuegbarer_platz = $lager->getPlatzVerfuegbar();


		if($gegenstand->ist_stapelbar)
		{
			$stack = $gegenstand
				->gegenstandStack($lager->typ_id)
				->first();
			if(is_null($stack))
			{
				$verfuegbarer_platz -= $anzahl;
			}
			else
			{
				$verfuegbarer_platz -= ceil($anzahl / $stack->anzahl);
			}
		}
		else
		{
			$verfuegbarer_platz -= $anzahl;
		}

		if($verfuegbarer_platz < 0)
		{
			return redirect()->back()->with('message', ['typ' => 'error', 'text' => 'Die Anzahl überschreitet das Lagerlimit!']);
		}

		$gegenstand_lager->gegenstand_id = $gegenstand_id;
		$gegenstand_lager->lager_id = $lager_id;
		$gegenstand_lager->anzahl += $anzahl;

		if($gegenstand_lager->anzahl <= 0)
		{
			if($gegenstand_lager->forceDelete())
			{
				return redirect()->back()->with('message', ['typ' => 'success', 'text' => "Gegenstand wurde aus lager entfernt"]);
			};
		}
		else
		{
			if($gegenstand_lager->save())
			{
				return redirect()->back()->with('message', ['typ' => 'success', 'text' => "Es wurden {$anzahl} {$gegenstand_lager->gegenstand->name} eingelagert"]);
			}
		}

		return redirect()->back()->with('message', ['typ' => 'error', 'text' => "Es ist ein Fehler aufgetreten!"]);
	}
}
