@extends('layouts.app')

@section('content')
	<div class="modal fade" id="new-lager" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content bg-secondary">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Lager hinzufügen</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form method="POST" action="{{ route('lager.store') }}">
					@csrf
					<div class="modal-body">
						@include('components.input', [
							'name' => 'name',
							'label' => 'Name',
							'required' => true,
						])
						@include('components.select', [
							'classes' => 'mt-2',
							'name' => 'ort_id',
							'label' => 'Ort Auswählen',
							'required' => true,
							'datas' => $lagerorte,
							'data_value' => 'lagerort_id',
							'data_text' => 'name',
						])
						@include('components.select', [
							'classes' => 'mt-2',
							'name' => 'typ_id',
							'label' => 'Typ Auswählen',
							'required' => true,
							'datas' => $lagertypen,
							'data_value' => 'lagertyp_id',
							'data_text' => 'name',
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

	<div class="container-fluid pt-4 px-4">
		<div class="row d-flex align-items-center mb-3">
			<div class="col-6">
				<h1 class="text-primary">Lagerplätze</h1>
			</div>
			<div class="col-6 text-end">
				@include('components.iconbutton', [
					'icon' => 'fa-plus',
					'text' => 'Lager hinzufügen',
					'url' => 'javascript:;',
					'extra_attributes' => 'data-bs-toggle=modal data-bs-target=#new-lager'
				])
			</div>
		</div>
		<div class="row g-4">
			<div class="col-12">
				<div class="bg-secondary rounded h-100 p-4">
					<div class="table-responsive">
						<table class="table table-hover">
							<thead>
								<tr>
									<th scope="col">ID</th>
									<th scope="col">Name</th>
									<th scope="col">Ort</th>
									<th scope="col">Typ</th>
									<th scope="col">Verfügbarer Platz</th>
									<th scope="col" colspan=2></th>
								</tr>
							</thead>
							<tbody>
								@forelse($lagers as $lager)
									<tr>
										<th scope="row">{{ $lager->lager_id }}</th>
										<td>{{ $lager->name }}</td>
										<td>{{ $lager->ort->name }}</td>
										<td >{{ $lager->typ->name }}</td>
										<td>{{ $lager->getVerfuegbarerPlatz() }} / {{ $lager->typ->platz }}</td>
										<td class="text-end">
											@include('components.iconbutton', [
												'color' => 'info',
												'hovertext' => 'Lager anzeigen',
												'icon' => 'fa-eye text-white',
												'url' => route('lager.show', ['id' => $lager->lager_id])
											])
											@include('components.iconbutton', [
												'color' => 'primary',
												'icon' => 'fa-edit',
												'hovertext' => 'bearbeiten',
												'extra_attributes' => "data-bs-toggle=modal data-bs-target=#edit-lager-{$lager->lager_id}",
											])
											@include('components.iconbutton', [
												'color' => 'primary',
												'icon' => 'fa-trash',
												'hovertext' => 'löschen',
												'url' => route('lager.delete', ['id' => $lager->lager_id])
											])
										</td>
									</tr>
									<div class="modal fade" id="edit-lager-{{ $lager->lager_id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content bg-secondary">
												<div class="modal-header">
													<h5 class="modal-title" id="exampleModalLabel">Lager bearbeiten</h5>
													<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
												</div>
												<form method="POST" action="{{ route('lager.update', ['id' => $lager->lager_id]) }}">
													@csrf
													<div class="modal-body">
														@include('components.input', [
															'name' => 'name',
															'label' => 'Name',
															'required' => true,
															'value' => $lager->name,
														])
														@include('components.select', [
															'classes' => 'mt-2',
															'name' => 'ort_id',
															'label' => 'Ort Auswählen',
															'required' => true,
															'datas' => $lagerorte,
															'data_value' => 'lagerort_id',
															'data_text' => 'name',
															'default_selected' => $lager->ort->lagerort_id,
														])
														@include('components.select', [
															'classes' => 'mt-2',
															'name' => 'typ_id',
															'label' => 'Typ Auswählen',
															'required' => true,
															'datas' => $lagertypen,
															'data_value' => 'lagertyp_id',
															'data_text' => 'name',
															'default_selected' => $lager->typ->lagertyp_id,
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
		@if($geloeschte_lager->count() > 0)
			<div class="row d-flex align-items-center my-3">
				<div class="col-6">
					<h3 class="text-primary">Gelöschte Lager</h1>
				</div>
			</div>
			<div class="row g-4">
				<div class="col-12">
					<div class="bg-secondary rounded h-100 p-4">
						<div class="table-responsive">
							<table class="table table-hover">
								<thead>
									<tr>
										<th scope="col">ID</th>
										<th scope="col">Name</th>
										<th scope="col">Gelöscht am</th>
										<th scope="col" colspan=2></th>
									</tr>
								</thead>
								<tbody>
									@foreach($geloeschte_lager as $lager)
										<tr>
											<th scope="row">{{ $lager->lager_id }}</th>
											<td>{{ $lager->name }}</td>
											<td>{{ date('d.m.Y H:i:s', strtotime($lager->deleted_at)) }}</td>
											<td class="text-end">
												@include('components.iconbutton', [
													'color' => 'primary',
													'icon' => 'fa-trash-restore',
													'hovertext' => 'wiederherstellen',
													'url' => route('lager.restore', ['id' => $lager->lager_id])
												])
												@include('components.iconbutton', [
													'color' => 'primary',
													'icon' => 'fa-trash',
													'hovertext' => 'für immer löschen',
													'url' => route('lager.delete.permanent', ['id' => $lager->lager_id])
												])
											</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		@endif
	</div>
@endsection
