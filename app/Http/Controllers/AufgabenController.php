<?php

namespace App\Http\Controllers;

use App\Models\Aufgabe;
use App\Models\Kommentar;
use App\Models\User;
use Illuminate\Http\Request;

class AufgabenController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function index()
	{
		$aufgaben = Aufgabe::orderBy('status', 'ASC')
			->orderBy('priorisierung', 'DESC')
			->get();
		$user = User::all();

		$status = [
			0 => 'Offen',
			1 => 'In Bearbeitung',
			2 => 'Erledigt',
		];

		$priorisierung = [
			0 => 'Am Niedrigsten',
			1 => 'Niedrig',
			2 => 'Neutral',
			3 => 'Hoch',
			4 => 'Sehr Hoch',
		];

		return view('aufgaben.index', [
			'aufgaben' => $aufgaben,
			'user' => $user,
			'status' => $status,
			'priorisierung' => $priorisierung,
		]);
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(Request $request)
	{
		$request->flash();
		$aufgabe = new Aufgabe();
		$aufgabe->titel = $request->titel;
		$aufgabe->beschreibung = $request->beschreibung;
		$aufgabe->author_id = auth()->user()->id;
		$aufgabe->zugewiesen_id = (int)$request->zugewiesen_id;
		$aufgabe->priorisierung = (int)$request->priorisierung;

		if($aufgabe->save())
		{
			return redirect()->back()->with('message', ['text' => "Die Aufgabe {$request->titel} wurde erfolgreich angelegt", 'typ' => 'success']);
		}

		return redirect()->back()->with(["message"=> ["typ"=> "error", 'text' => 'Ein unerwarteter Fehler ist aufgetreten!']]);
	}

	/**
	 * Display the specified resource.
	 */
	public function show(int $id)
	{
		$aufgabe = Aufgabe::with('kommentare')
			->findOrFail($id);

		return view('aufgaben.show', [
			'aufgabe' => $aufgabe,
		]);
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(Request $request, int $id)
	{
		$request->flash();
		$aufgabe = Aufgabe::findOrFail($id);

		$aufgabe->titel = $request->titel;
		$aufgabe->beschreibung = $request->beschreibung;
		$aufgabe->zugewiesen_id = $request->zugewiesen_id;
		$aufgabe->status = $request->status;

		if($aufgabe->isDirty())
		{
			if($aufgabe->save())
			{
				return redirect()->back()->with('message', ['typ' => 'success', 'text' => "Die Aufgabe wurde erfolgreich geändert"]);
			};
		}
		return redirect()->back();
	}

	public function comment(Request $request)
	{
		$kommentar = new Kommentar();
		$kommentar->aufgaben_id = (int)$request->aufgaben_id;
		$kommentar->author_id = auth()->user()->id;
		$kommentar->text = $request->kommentar;

		if($kommentar->save())
		{
			return redirect()->back()->with('message', ['text' => "Kommentar erstellt", 'typ' => 'success']);
		}

		return redirect()->back()->with(["message"=> ["typ"=> "error", 'text' => 'Ein unerwarteter Fehler ist aufgetreten!']]);
	}
}
