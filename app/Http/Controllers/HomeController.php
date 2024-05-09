<?php

namespace App\Http\Controllers;

use App\Models\Gegenstand;
use App\Models\GegenstandLager;
use App\Models\Lager;
use App\Models\LagerTyp;
use Illuminate\Http\Request;
use App\Traits\ApiTrait;
use App\Traits\LagerTrait;

class HomeController extends Controller
{
	use ApiTrait,
		LagerTrait;
	/**
	 * Display a listing of the resource.
	 */
	public function index(Request $request)
	{
		$lagerplatz_total = Lager::getPlatzTotal();
		$lagerplatz_verfuegbar = Lager::getPlatzVerfuegbarTotal();

		$gegenstaende = Gegenstand::all();
		$lager = Lager::all();
		$lager = $lager->filter(function($item)
		{
			return $item->getVerfuegbarerPlatz() > 0;
		});

		return view('start', [
			'lagerplatz_total' => $lagerplatz_total,
			'lagerplatz_verfuegbar' => $lagerplatz_verfuegbar,
			'lagers' => $lager,
			'gegenstaende' => $gegenstaende,
		]);
	}

	/**
	 * Einlagern von Gegenständen
	 */
	public function store(Request $request)
	{
		$request->validate([
			'gegenstand_id' => 'required',
			'anzahl' => 'required',
			'lager_id' => 'required',
		]);
		$request->flash();

		return $this->einlagern($request->gegenstand_id, $request->lager_id, $request->anzahl);
	}

	/**
	 * Display the specified resource.
	 */
	public function show(string $id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(string $id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(Request $request, string $id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(string $id)
	{
		//
	}
}
