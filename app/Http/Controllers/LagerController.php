<?php

namespace App\Http\Controllers;

use App\Http\Requests\LagerStoreRequest;
use App\Models\Gegenstand;
use App\Models\GegenstandLager;
use App\Models\Lager;
use App\Models\LagerOrt;
use App\Models\LagerTyp;
use App\Traits\LagerTrait;
use Illuminate\Http\Request;

class LagerController extends Controller
{
	use LagerTrait;

   /**
	 * Display a listing of the resource.
	 */
	public function index(Request $request)
	{
		$lager = Lager::with(['ort', 'typ'])
			->get();
		$lagerorte = LagerOrt::get();
		$lagertypen = LagerTyp::get();

		$geloeschte_lager = Lager::onlyTrashed()
			->orderBy('deleted_at', 'DESC')
			->get();

		return view('lager.index', [
			'lagers' => $lager,
			'lagerorte' => $lagerorte,
			'lagertypen' => $lagertypen,
			'geloeschte_lager' => $geloeschte_lager
		]);
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(LagerStoreRequest $request)
	{
		$request->flash();
		$lager = new Lager();
		$lager->name = $request->name;
		$lager->ort_id = $request->ort_id;
		$lager->typ_id = $request->typ_id;

		if($lager->save())
		{
			return redirect()->back()->with('message', ['text' => "Das Lager {$request->name} wurde erfolgreich angelegt", 'typ' => 'success']);
		}

		return redirect()->back()->with(["message"=> ["typ"=> "error", 'text' => 'Ein unerwarteter Fehler ist aufgetreten!']]);
	}

	/**
	 * Display the specified resource.
	 */
	public function show(int $id)
	{
		$lager = Lager::findOrFail($id);
		$alle_gegenstaende = Gegenstand::all();

		return view('lager.show', [
			'lager' => $lager,
			'alle_gegenstaende' => $alle_gegenstaende,

		]);
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(Request $request, int $lager_id, int $gegenstand_id)
	{
		$gegenstand_lager = GegenstandLager::isLagerId($lager_id)
			->isGegenstandId($gegenstand_id)
			->first();
		$anzahl = (int)$request->anzahl;

		$this->einlagern($gegenstand_id, $lager_id, $anzahl);
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(LagerStoreRequest $request, string $id)
	{
		$request->flash();
		$lager = Lager::findOrFail($id);
		$name = $request->name;
		$ort = $request->ort_id;
		$typ = $request->typ_id;

		$lager->name = $name;
		$lager->ort_id = $ort;
		$lager->typ_id = $typ;

		if($lager->isDirty())
		{
			if($lager->save())
			{
				return redirect()->back()->with('message', ['typ' => 'success', 'text' => "Das Lager wurde erfolgreich geändert"]);
			};
		}
		return redirect()->back();
	}
	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(string $id)
	{
		$lager = Lager::findOrFail($id);

		$lager_name = $lager->name;

		if($lager->gegenstaendeLager->count() > 0)
		{
			return redirect()->back()->with('message', ['text' => "Das Lager {$lager_name} kann nicht gelöscht werden! Es sind noch gegenstände eingelagert!", 'typ' => 'error']);
		}

		if($lager->delete())
		{
			return redirect()->back()->with('message', ['text'=> "Das Lager {$lager_name} wurde gelöscht!", 'typ' => 'success']);
		}
		return redirect()->back()->with(['message'=> ['typ'=> 'error', 'text' => "Das Lager {$lager_name} konnte nicht gelöscht werden"]]);
	}

	public function restore(string $id)
	{
		$lager = Lager::withTrashed()->findOrFail($id);

		if($lager->restore())
		{
			return redirect()->back()->with("message", ["text"=> "Das Lager {$lager->name} wurde wiederhergestellt","typ"=> "success"]);
		}
		return redirect()->back()->with(["message"=> ["typ"=> "error", 'text' => "Das Lager {$lager->name} konnte nicht wiederhergestellt werden"]]);
	}

	public function deletePermanent(string $id)
	{
		$lager = Lager::withTrashed()->findOrFail($id);

		if($lager->forceDelete())
		{
			return redirect()->back()->with("message", ["text"=> "Das Lager {$lager->name} wurde permanent entfernt","typ"=> "success"]);
		}
		return redirect()->back()->with(["message"=> ["typ"=> "error", 'text' => "Das Lager {$lager->name} konnte entfernt werden"]]);
	}
}
