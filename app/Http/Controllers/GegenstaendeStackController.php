<?php

namespace App\Http\Controllers;

use App\Models\Gegenstand;
use App\Models\GegenstandStack;
use App\Models\LagerTyp;
use Illuminate\Http\Request;

class GegenstaendeStackController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function index()
	{
		$gegenstaende = Gegenstand::istStapelbar()
			->get();
		$lagertyp = LagerTyp::all();
		$stacks = GegenstandStack::orderBy('lagertyp_id', 'DESC')
			->get();

		return view('stack.index', [
			'gegenstaende' => $gegenstaende,
			'stacks' => $stacks,
			'lagertyp' => $lagertyp,
		]);
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(Request $request)
	{
		$request->flash();
		$stack = GegenstandStack::isGegenstandId($request->gegenstand_id)
			->isLagerTypId($request->lagertyp_id)
			->firstOrNew();

		$gegenstand = Gegenstand::find($request->gegenstand_id);

		if($gegenstand->ist_stapelbar == 0)
		{
			return redirect()
				->back()
				->with(["message"=> ["typ"=> "error", 'text' => "Der Gegenstand {$gegenstand->name} ist nicht stapelbar, du kannst dafür keinen Stack anlegen"]]);
		}

		if(!is_null($stack->anzahl))
		{
			return redirect()
				->back()
				->with(["message"=> ["typ"=> "error", 'text' => "Der Stack für {$stack->gegenstand->name} / {$stack->lagertyp->name} existiert bereits, um es zu ändern bearbeite dies"]]);
		}
		else
		{
			$stack->gegenstand_id = $request->gegenstand_id;
			$stack->lagertyp_id = $request->lagertyp_id;
			$stack->anzahl = $request->anzahl;
		}

		if($stack->save())
		{
			return redirect()
				->back()
				->with('message', ['text' => "Der Stack wurde erfolgreich angelegt", 'typ' => 'success']);
		}

		return redirect()
			->back()
			->with(["message"=> ["typ"=> "error", 'text' => 'Ein unerwarteter Fehler ist aufgetreten!']]);
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(Request $request, string $id)
	{
		$request->flash();
		$stack = GegenstandStack::findOrFail($id);
		$anzahl = $request->anzahl;

		$stack->anzahl = $anzahl;

		if($stack->isDirty())
		{
			if($stack->save())
			{
				return redirect()->back()->with('message', ['typ' => 'success', 'text' => "Der Stack wurde erfolgreich geändert"]);
			};
		}
		return redirect()->back();
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(Request $request, int $id)
	{
		$stack = GegenstandStack::findOrFail($id);

		$gegenstand_name = $stack->gegenstand->name;

		if($stack->delete())
		{
			return redirect()->back()->with('message', ['text'=> "Der Stack für {$gegenstand_name} wurde gelöscht!", 'typ' => 'success']);
		}
		return redirect()->back()->with(['message'=> ['typ'=> 'error', 'text' => "Der Stack für {$gegenstand_name} konnte nicht gelöscht werden"]]);
	}
}
