<?php

use Illuminate\Support\Facades\Route;

$controller = '\\App\Http\\Controllers\\';


Route::get('login', [\App\Http\Controllers\LoginController::class,'index'])
	->name('login');

Route::match(['get', 'post'],'userlogin', [\App\Http\Controllers\LoginController::class,'login'])
	->name('userlogin');

Route::middleware(['auth'])
	->group(function () use($controller) {

		Route::prefix('')
			->controller($controller. 'HomeController')
			->group(function()
			{
				Route::get('/', 'index')
					->name('startseite');
				Route::post('einlagern', 'store')
					->name('einlagern');
			});


		Route::get('logout', [\App\Http\Controllers\LoginController::class,'logout'])
			->name('logout');

		Route::prefix('lager')
			->name('lager.')
			->group(function () use($controller) {
				Route::prefix('')
					->name('')
					->controller($controller. 'LagerController')
					->group(function () {
						Route::get('', 'index')
							->name('index');
						Route::get('lager/{id}', 'show')
							->name('show');
						Route::post('lager/{lager_id}/edit/{gegenstand_id}', 'edit')
							->name('edit');
						Route::post('',  'store')
							->name('store');
						Route::post('update/{id}',  'update')
							->name('update');

						Route::get('loeschen/{id}', 'destroy')
							->name('delete');
						Route::get('restore/{id}',  'restore')
							->name('restore');
						Route::get('delete/permanent/{id}',  'deletePermanent')
							->name('delete.permanent');
					});

				Route::prefix('typen')
					->name('typen.')
					->controller($controller. 'LagertypenController')
					->group(function () {
						Route::get('', 'index')
							->name('index');
						Route::post('',  'store')
							->name('store');
						Route::post('update/{id}',  'update')
							->name('update');

						Route::get('loeschen/{id}', 'destroy')
							->name('delete');
						Route::get('restore/{id}',  'restore')
							->name('restore');
						Route::get('delete/permanent/{id}',  'deletePermanent')
							->name('delete.permanent');
					});
				Route::prefix('orte')
					->name('orte.')
					->controller($controller. 'LagerorteController')
					->group(function () {
						Route::get('', 'index')
							->name('index');
						Route::post('',  'store')
							->name('store');
						Route::post('update/{id}',  'update')
							->name('update');

						Route::get('loeschen/{id}', 'destroy')
							->name('delete');
						Route::get('restore/{id}',  'restore')
							->name('restore');
						Route::get('delete/permanent/{id}',  'deletePermanent')
							->name('delete.permanent');
					});
			});
		Route::prefix('gegenstaende')
			->name('gegenstaende.')
			->controller($controller. 'GegenstaendeController')
			->group(function () {
				Route::get('', 'index')
					->name('index');
				Route::post('', 'store')
					->name('store');
				Route::post('update/{id}', 'update')
					->name('update');

				Route::get('loeschen/{id}', 'destroy')
					->name('delete');
				Route::get('restore/{id}', 'restore')
					->name('restore');
				Route::get('delete/permanent/{id}', 'deletePermanent')
					->name('delete.permanent');
			});
		Route::prefix('stack')
			->name('stack.')
			->controller($controller. 'GegenstaendeStackController')
			->group(function () {
				Route::get('', 'index')
					->name('index');
				Route::post('', 'store')
					->name('store');
				Route::post('update/{id}', 'update')
					->name('update');

				Route::get('loeschen/{id}', 'destroy')
					->name('delete');
				Route::get('restore/{id}', 'restore')
					->name('restore');
				Route::get('delete/permanent/{id}', 'deletePermanent')
					->name('delete.permanent');
			});

		Route::prefix('aufgaben')
			->name('aufgaben.')
			->controller($controller. 'AufgabenController')
			->group(function () {
				Route::get('', 'index')
					->name('index');
				Route::post('', 'store')
					->name('store');
				Route::get('aufgaben/{id}', 'show')
					->name('show');

				Route::post('aufgaben/kommentar', 'comment')
					->name('comment');
				Route::post('update/{id}', 'update')
					->name('update');

				Route::get('loeschen/{id}', 'destroy')
					->name('delete');
			});
	});
