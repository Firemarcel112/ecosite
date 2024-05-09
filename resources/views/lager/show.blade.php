@extends('layouts.app')
@section('content')
	<div class="container-fluid pt-4 px-4">
		<div class="row d-flex align-items-center mb-3">
			<div class="col-6">
				<h1 class="text-primary">Lager {{ $lager->name }}</h1>
			</div>
		</div>
		<div class="row g-4">
			<div class="col-sm-6 col-xl-6">
				<div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
					<i class="fa-thin fa-container-storage fa-3x text-primary"></i>
					<div class="ms-3">
						<p class="mb-2">Lagerplatz Total</p>
						<h6 class="mb-0 text-end">{{ $lager->typ->platz  }}</h6>
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-xl-6">
				<div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
					<i class="fa-thin fa-container-storage fa-3x text-primary"></i>
					<div class="ms-3">
						<p class="mb-2">Lagerplatz Verfügbar</p>
						<h6 class="mb-0 text-end">{{ $lager->getPlatzVerfuegbar() }}</h6>
					</div>
				</div>
			</div>
		</div>
		<div class="row g-4 mt-4">
			<div class="col-12">
				<div class="bg-secondary rounded h-100 p-4">
					<div class="table-responsive">
						<table class="table table-hover">
							<thead>
								<tr>
									<th scope="col">Gegenstand-ID</th>
									<th scope="col">Name</th>
									<th scope="col">Menge</th>
									<th scope="col">Platz im Lager</th>
									<th colspan="2"></th>
								</tr>
							</thead>
							<tbody>
								@forelse($lager->gegenstaendeLager as $eingelagert)
									<tr>
										@php
											if($eingelagert->gegenstand->ist_stapelbar == 1)
											{
												$has_gegenstand_stack = is_null($eingelagert->gegenstand->gegenstandStack($lager->typ->lagertyp_id)->first()) ? false : true;
											}
											else {
												$has_gegenstand_stack = true;
											}
										@endphp
										<th scope="row">{{ $eingelagert->gegenstand->gegenstand_id }}</th>
										<td>{{ $eingelagert->gegenstand->name }}</td>
										<td>{{ $eingelagert->anzahl }}</td>
										<td>{{ $eingelagert->getPlatzImLager() }}
											@if(!$has_gegenstand_stack)
												@include('components.icon', [
													'icon' => 'fa-warning',
													'classes' => 'text-warning',
													'hovertext' => 'Der Gegenstand hat keinen Stack',
												])
											@endif
										</td>
										<td class="text-end">
											@include('components.iconbutton', [
												'color' => 'primary',
												'icon' => 'fa-edit',
												'hovertext' => 'bearbeiten',
												'extra_attributes' => "data-bs-toggle=modal data-bs-target=#edit-anzahl-{$eingelagert->gegenstand_lager_id}",
											])
										</td>
									</tr>
									<div class="modal fade" id="edit-anzahl-{{ $eingelagert->gegenstand_lager_id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content bg-secondary">
												<div class="modal-header">
													<h5 class="modal-title" id="exampleModalLabel">{{ $eingelagert->gegenstand->name }} bearbeiten</h5>
													<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
												</div>
												<form method="POST" action="{{ route('lager.edit', ['lager_id' => $lager->lager_id, 'gegenstand_id' => $eingelagert->gegenstand->gegenstand_id]) }}">
													@csrf
													<div class="modal-body">
														@include('components.input', [
															'name' => 'anzahl',
															'label' => 'Anzahl',
															'required' => true,
															'value' => $eingelagert->anzahl,
														])
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Schließen</button>
														<button type="submit" class="btn btn-primary">Speichern</button>
													</div>
												</form>
											</div>
										</div>
									</div>
								@empty
									<tr>
										<td colspan="12" class="text-center">Keine Daten vorhanden</td>
									</tr>
								@endforelse
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="mt-4 col-6">
			@if($lager->getPlatzVerfuegbar() > 0)
				<form class="" method="POST" action="{{ route('einlagern') }}">
					<h3 class="m-2">Gegenstände einlagern</h3>
					<div class="container-fluid p-2">
						<input type="hidden" name="lager_id" value="{{ $lager->lager_id }}">
						@csrf
						@include('components.select', [
							'classes' => 'border border-primary rounded',
							'name' => 'gegenstand_id',
							'label' => 'Gegenstand Auswählen',
							'required' => true,
							'datas' => $alle_gegenstaende,
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
						<div class="mt-4 text-end">
							<button type="submit" class="btn btn-primary">Einlagern</button>
						</div>
					</div>

				</form>
			@endif
		</div>
	</div>
@endsection
