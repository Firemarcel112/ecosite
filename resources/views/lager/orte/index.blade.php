@extends('layouts.app')

@section('content')
	<div class="modal fade" id="new-ort" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content bg-secondary">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Ort hinzufügen</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form method="POST" action="{{ route('lager.orte.store') }}">
					@csrf
					<div class="modal-body">
						@include('components.input', [
							'name' => 'name',
							'label' => 'Name',
							'required' => true,
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
				<h1 class="text-primary">Lagerorte</h1>
			</div>
			<div class="col-6 text-end">
				@include('components.iconbutton', [
					'icon' => 'fa-plus',
					'text' => 'Ort hinzufügen',
					'url' => 'javascript:;',
					'extra_attributes' => 'data-bs-toggle=modal data-bs-target=#new-ort'
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
									<th scope="col" colspan=2></th>
								</tr>
							</thead>
							<tbody>
								@forelse($lagerorte as $lagerort)
									<tr>
										<th scope="row">{{ $lagerort->lagerort_id }}</th>
										<td>{{ $lagerort->name }}</td>
										<td class="text-end">
											@include('components.iconbutton', [
												'color' => 'primary',
												'icon' => 'fa-edit',
												'hovertext' => 'bearbeiten',
												'extra_attributes' => "data-bs-toggle=modal data-bs-target=#edit-ort-{$lagerort->lagerort_id}",
											])
											@include('components.iconbutton', [
												'color' => 'primary',
												'icon' => 'fa-trash',
												'hovertext' => 'löschen',
												'url' => route('lager.orte.delete', ['id' => $lagerort->lagerort_id])
											])
										</td>
									</tr>
									<div class="modal fade" id="edit-ort-{{ $lagerort->lagerort_id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content bg-secondary">
												<div class="modal-header">
													<h5 class="modal-title" id="exampleModalLabel">Ort bearbeiten</h5>
													<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
												</div>
												<form method="POST" action="{{ route('lager.orte.update', ['id' => $lagerort->lagerort_id]) }}">
													@csrf
													<div class="modal-body">
														@include('components.input', [
															'name' => 'name',
															'label' => 'Name',
															'required' => true,
															'value' => $lagerort->name,
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
		@if($geloeschte_orte->count() > 0)
			<div class="row d-flex align-items-center my-3">
				<div class="col-6">
					<h3 class="text-primary">Gelöschte Orte</h1>
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
									@foreach($geloeschte_orte as $lagerort)
										<tr>
											<th scope="row">{{ $lagerort->lagerort_id }}</th>
											<td>{{ $lagerort->name }}</td>
											<td>{{ date('d.m.Y H:i:s', strtotime($lagerort->deleted_at)) }}</td>
											<td class="text-end">
												@include('components.iconbutton', [
													'color' => 'primary',
													'icon' => 'fa-trash-restore',
													'hovertext' => 'wiederherstellen',
													'url' => route('lager.orte.restore', ['id' => $lagerort->lagerort_id])
												])
												@include('components.iconbutton', [
													'color' => 'primary',
													'icon' => 'fa-trash',
													'hovertext' => 'für immer löschen',
													'url' => route('lager.orte.delete.permanent', ['id' => $lagerort->lagerort_id])
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
