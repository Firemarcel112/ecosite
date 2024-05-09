<?php

namespace App\Http\Controllers;

use App\Models\Gegenstand;
use Illuminate\Http\Request;

class GegenstaendeController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function index()
	{
		$gegenstaende = Gegenstand::get();

		$geloeschte_gegenstaende = Gegenstand::onlyTrashed()
			->orderBy('deleted_at', 'DESC')
			->get();

		return view('gegenstaende.index', [
			'gegenstaende' => $gegenstaende,
			'geloeschte_gegenstaende' => $geloeschte_gegenstaende
		]);
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(Request $request)
	{
		$request->flash();
		$gegenstand = new Gegenstand();
		$gegenstand->name = $request->name;
		$gegenstand->ist_stapelbar = ($request->stapelbar) ? 1 : 0;

		if($gegenstand->save())
		{
			return redirect()->back()->with('message', ['text' => "Der Gegenstand {$request->name} wurde erfolgreich angelegt", 'typ' => 'success']);
		}

		return redirect()->back()->with(["message"=> ["typ"=> "error", 'text' => 'Ein unerwarteter Fehler ist aufgetreten!']]);
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(Request $request, string $id)
	{
		$request->flash();
		$gegenstand = Gegenstand::findOrFail($id);
		$name = $request->name;
		$stapelbar = ($request->stapelbar) ? 1 : 0;

		$gegenstand->name = $name;
		$gegenstand->ist_stapelbar = $stapelbar;

		if($gegenstand->isDirty())
		{
			if($gegenstand->save())
			{
				return redirect()->back()->with('message', ['typ' => 'success', 'text' => "Der Gegenstand wurde erfolgreich geändert"]);
			};
		}
		return redirect()->back();
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(string $id)
	{
		$gegenstand = Gegenstand::findOrFail($id);

		$gegenstand_name = $gegenstand->name;

		if($gegenstand->delete())
		{
			return redirect()->back()->with('message', ['text'=> "Der Gegenstand {$gegenstand_name} wurde gelöscht!", 'typ' => 'success']);
		}
		return redirect()->back()->with(['message'=> ['typ'=> 'error', 'text' => "Der Gegenstand {$gegenstand_name} konnte nicht gelöscht werden"]]);
	}

	public function restore(string $id)
	{
		$gegenstand = Gegenstand::withTrashed()->findOrFail($id);

		if($gegenstand->restore())
		{
			return redirect()->back()->with("message", ["text"=> "Der Gegenstand {$gegenstand->name} wurde wiederhergestellt","typ"=> "success"]);
		}
		return redirect()->back()->with(["message"=> ["typ"=> "error", 'text' => "Der Gegenstand {$gegenstand->name} konnte nicht wiederhergestellt werden"]]);
	}

	public function deletePermanent(string $id)
	{
		$gegenstand = gegenstand::withTrashed()->findOrFail($id);

		if($gegenstand->forceDelete())
		{
			return redirect()->back()->with("message", ["text"=> "Der Gegenstand {$gegenstand->name} wurde permanent entfernt","typ"=> "success"]);
		}
		return redirect()->back()->with(["message"=> ["typ"=> "error", 'text' => "Der Gegenstand {$gegenstand->name} konnte entfernt werden"]]);
	}
}
