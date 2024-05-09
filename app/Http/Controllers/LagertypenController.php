<?php

namespace App\Http\Controllers;

use App\Models\LagerTyp;
use Illuminate\Http\Request;

class LagerTypenController extends Controller
{
   /**
	 * Display a listing of the resource.
	 */
	public function index(Request $request)
	{
		$lagertypen = LagerTyp::get();

		$geloeschte_typen = LagerTyp::onlyTrashed()
			->orderBy('deleted_at', 'DESC')
			->get();

		return view('lager.typen.index', [
			'lagertypen' => $lagertypen,
			'geloeschte_typen' => $geloeschte_typen
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
	public function store(Request $request)
	{
		$request->flash();
		$lagertyp = new LagerTyp();
		$lagertyp->name = $request->name;
		$lagertyp->platz = $request->platz;

		if($lagertyp->save())
		{
			return redirect()->back()->with('message', ['text' => "Der Typ {$request->name} wurde erfolgreich angelegt", 'typ' => 'success']);
		}

		return redirect()->back()->with(["message"=> ["typ"=> "error", 'text' => 'Ein unerwarteter Fehler ist aufgetreten!']]);
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
		$request->flash();
		$lagertyp = LagerTyp::findOrFail($id);
		$name = $request->name;
		$platz = $request->platz;

		$lagertyp->name = $name;
		$lagertyp->platz = $platz;

		if($lagertyp->isDirty())
		{
			if($lagertyp->save())
			{
				return redirect()->back()->with('message', ['typ' => 'success', 'text' => "Der Typ wurde erfolgreich geändert"]);
			};
		}
		return redirect()->back();
	}
	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(string $id)
	{
		$lagertyp = Lagertyp::findOrFail($id);

		$lagertyp_name = $lagertyp->name;

		if($lagertyp->delete())
		{
			return redirect()->back()->with('message', ['text'=> "Der Typ {$lagertyp_name} wurde gelöscht!", 'typ' => 'success']);
		}
		return redirect()->back()->with(['message'=> ['typ'=> 'error', 'text' => "Der Typ {$lagertyp_name} konnte nicht gelöscht werden"]]);
	}

	public function restore(string $id)
	{
		$lagertyp = LagerTyp::withTrashed()->findOrFail($id);

		if($lagertyp->restore())
		{
			return redirect()->back()->with("message", ["text"=> "Der Typ {$lagertyp->name} wurde wiederhergestellt","typ"=> "success"]);
		}
		return redirect()->back()->with(["message"=> ["typ"=> "error", 'text' => "Der Typ {$lagertyp->name} konnte nicht wiederhergestellt werden"]]);
	}

	public function deletePermanent(string $id)
	{
		$lagertyp = LagerTyp::withTrashed()->findOrFail($id);

		if($lagertyp->forceDelete())
		{
			return redirect()->back()->with("message", ["text"=> "Der Typ {$lagertyp->name} wurde permanent entfernt","typ"=> "success"]);
		}
		return redirect()->back()->with(["message"=> ["typ"=> "error", 'text' => "Der Typ {$lagertyp->name} konnte entfernt werden"]]);
	}
}
