<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateUser extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'app:create-user {benutzername} {passwort}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Erstellt einen Benutzer';

	/**
	 * Execute the console command.
	 */
	public function handle()
	{
		$this->line('start');
		$benutzername = $this->argument('benutzername');
		$passwort = $this->argument('passwort');
		$user = new User();
		$user->username = $benutzername;
		$user->password = Hash::make($passwort, [
			'rounds' => env('BCRYPT_ROUNDS')
		]);
		if($user->save())
		{
			$this->line("Benutzer {$benutzername} wurde angelegt");
			$this->line("Passwort: {$passwort}");
		}
	}
}
