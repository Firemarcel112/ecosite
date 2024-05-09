@extends('layouts.app')
@section('content')
	<div class="container-fluid pt-4 px-4">
		<div class="row d-flex align-items-center mb-3">
			<div class="col-6">
				<h1 class="text-primary">Dashboard</h1>
			</div>
		</div>
		<div class="row g-4">
			<div class="col-sm-6 col-xl-3">
				<div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
					<i class="fa-thin fa-container-storage fa-3x text-primary"></i>
					<div class="ms-3">
						<p class="mb-2">Lagerplatz Total</p>
						<h6 class="mb-0 text-end">{{ $lagerplatz_total }}</h6>
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-xl-3">
				<div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
					<i class="fa-thin fa-container-storage fa-3x text-primary"></i>
					<div class="ms-3">
						<p class="mb-2">Lagerplatz Verfügbar</p>
						<h6 class="mb-0 text-end">{{ $lagerplatz_verfuegbar }}</h6>
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-xl-3">
				<div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
					<i class="fa-thin fa-container-storage fa-3x text-primary"></i>
					<div class="ms-3">
						<p class="mb-2">Spieler Online</p>
						<h6 class="mb-0 text-end">{{ $server_info['OnlinePlayers'] ?? 0 }} / {{ $server_info['TotalPlayers'] ?? 0 }}</h6>
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-xl-3">
				<div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
					<i class="fa-thin fa-container-storage fa-3x text-primary"></i>
					<div class="ms-3">
						<p class="mb-2">Aktuell Online</p>
						@foreach($server_info['OnlinePlayersNames'] ?? [] as $online_spieler)
							<span class="d-block">{{ $online_spieler }}</span>
						@endforeach
					</div>
				</div>
			</div>
		</div>
		<div class="mt-4 col-6">
			<form class="" method="POST" action="{{ route('einlagern') }}">
				<h3 class="m-2">Gegenstände einlagern</h3>
				<div class="container-fluid p-2">
					@csrf
					@include('components.select', [
						'classes' => 'border border-primary rounded',
						'name' => 'gegenstand_id',
						'label' => 'Gegenstand Auswählen',
						'required' => true,
						'datas' => $gegenstaende,
						'data_value' => 'gegenstand_id',
						'data_text' => 'name',
					])
					@include('components.input', [
						'classes' => 'border border-primary rounded mt-2',
						'name' => 'anzahl',
						'label' => 'Anzahl',
						'required' => true,
						'type' => 'number',
					])
					<div class="form-floating border border-primary rounded mt-2">
						<select class="form-select" id="lager_id" name="lager_id" aria-label="Lager Auswählen">
							@foreach($lagers ?? [] as $lager)
								<option value={{ $lager->lager_id }}>{{ $lager->name }} (Platz: {{ $lager->getVerfuegbarerPlatz() }} / {{ $lager->typ->platz }})</option>
							@endforeach
						</select>
						<label class="form-label @required(true)" for="lager_id">Lager Auswählen</label>
					</div>
					<div class="mt-4 text-end">
						<button type="submit" class="btn btn-primary">Einlagern</button>
					</div>
				</div>

			</form>
		</div>
	</div>
@endsection
