<?php

namespace App\Http\Controllers;

use App\Models\LagerOrt;
use Illuminate\Support\MessageBag;
use Illuminate\Http\Request;

class LagerOrteController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function index(Request $request)
	{
		$lagerorte = LagerOrt::get();

		$geloeschte_orte = LagerOrt::onlyTrashed()
			->orderBy('deleted_at', 'DESC')
			->get();

		return view('lager.orte.index', [
			'lagerorte' => $lagerorte,
			'geloeschte_orte' => $geloeschte_orte
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
		$lagerort = new LagerOrt();
		$lagerort->name = $request->name;

		if($lagerort->save())
		{
			return redirect()->back()->with('message', ['text' => "Der Ort {$request->name} wurde erfolgreich angelegt", 'typ' => 'success']);
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
		$lagerort = LagerOrt::findOrFail($id);
		$name = $request->name;

		$lagerort->name = $name;

		if($lagerort->isDirty())
		{
			if($lagerort->save())
			{
				return redirect()->back()->with('message', ['typ' => 'success', 'text' => "Der Ort wurde erfolgreich geändert"]);
			};
		}
		return redirect()->back();
	}
	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(string $id)
	{
		$lagerort = LagerOrt::findOrFail($id);

		$lagerort_name = $lagerort->name;

		if($lagerort->delete())
		{
			return redirect()->back()->with('message', ['text'=> "Der Ort {$lagerort_name} wurde gelöscht!", 'typ' => 'success']);
		}
		return redirect()->back()->with(['message'=> ['typ'=> 'error', 'text' => "Der Ort {$lagerort_name} konnte nicht gelöscht werden"]]);
	}

	public function restore(string $id)
	{
		$lagerort = Lagerort::withTrashed()->findOrFail($id);

		if($lagerort->restore())
		{
			return redirect()->back()->with("message", ["text"=> "Der Ort {$lagerort->name} wurde wiederhergestellt","typ"=> "success"]);
		}
		return redirect()->back()->with(["message"=> ["typ"=> "error", 'text' => "Der Ort {$lagerort->name} konnte nicht wiederhergestellt werden"]]);
	}

	public function deletePermanent(string $id)
	{
		$lagerort = Lagerort::withTrashed()->findOrFail($id);

		if($lagerort->forceDelete())
		{
			return redirect()->back()->with("message", ["text"=> "Der Ort {$lagerort->name} wurde permanent entfernt","typ"=> "success"]);
		}
		return redirect()->back()->with(["message"=> ["typ"=> "error", 'text' => "Der Ort {$lagerort->name} konnte entfernt werden"]]);
	}
}
