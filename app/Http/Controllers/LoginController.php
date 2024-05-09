<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Exception;

class LoginController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function index()
	{
		return view('login');
	}

	public function login(Request $request)
	{
		$request->flashExcept('password');
		$credentials = $request->validate([
			'username' => 'required',
			'password' => 'required',
		]);

		try
		{
			if(Auth::attempt($credentials, true))
			{
				$request->session()->regenerate();

				return redirect()->route('startseite');
			}
		} catch(Exception $e)
		{
			if(config('app.debug'))
			{
				return redirect()->back()
					->with('message', ['text' => $e->getMessage(), 'typ' => 'error']);
			}
		}
		return redirect()->back()
			->with('message', ['text' => 'Zugangsdaten Falsch!', 'typ' => 'error']);

	}

	public function logout(Request $request)
	{
		Auth::logout();
		session()->regenerate();
		return redirect()->route('startseite');
	}
}
