@extends('layouts.app')

@section('content')
	<div class="modal fade" id="new-typ" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content bg-secondary">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Typ hinzufügen</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form method="POST" action="{{ route('lager.typen.store') }}">
					@csrf
					<div class="modal-body">
						@include('components.input', [
							'name' => 'name',
							'label' => 'Name',
							'required' => true,
						])
						@include('components.input', [
							'classes' => 'mt-2',
							'name' => 'platz',
							'label' => 'Anzahl an Platz',
							'required' => true,
							'type' => 'number',
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
				<h1 class="text-primary">Lagertypen</h1>
			</div>
			<div class="col-6 text-end">
				@include('components.iconbutton', [
					'icon' => 'fa-plus',
					'text' => 'Typ hinzufügen',
					'url' => 'javascript:;',
					'extra_attributes' => 'data-bs-toggle=modal data-bs-target=#new-typ'
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
									<th scope="col">Platz</th>
									<th scope="col" colspan=2></th>
								</tr>
							</thead>
							<tbody>
								@forelse($lagertypen as $lagertyp)
									<tr>
										<th scope="row">{{ $lagertyp->lagertyp_id }}</th>
										<td>{{ $lagertyp->name }}</td>
										<td>{{ $lagertyp->platz }}</td>
										<td class="text-end">
											@include('components.iconbutton', [
												'color' => 'primary',
												'icon' => 'fa-edit',
												'hovertext' => 'bearbeiten',
												'extra_attributes' => "data-bs-toggle=modal data-bs-target=#edit-typ-{$lagertyp->lagertyp_id}",
											])
											@include('components.iconbutton', [
												'color' => 'primary',
												'icon' => 'fa-trash',
												'hovertext' => 'löschen',
												'url' => route('lager.typen.delete', ['id' => $lagertyp->lagertyp_id])
											])
										</td>
									</tr>
									<div class="modal fade" id="edit-typ-{{ $lagertyp->lagertyp_id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content bg-secondary">
												<div class="modal-header">
													<h5 class="modal-title" id="exampleModalLabel">Typ bearbeiten</h5>
													<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
												</div>
												<form method="POST" action="{{ route('lager.typen.update', ['id' => $lagertyp->lagertyp_id]) }}">
													@csrf
													<div class="modal-body">
														@include('components.input', [
															'name' => 'name',
															'label' => 'Name',
															'required' => true,
															'value' => $lagertyp->name,
														])
														@include('components.input', [
															'classes' => 'mt-2',
															'name' => 'platz',
															'label' => 'Anzahl an Platz',
															'required' => true,
															'type' => 'number',
															'value' => $lagertyp->platz,
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
		@if($geloeschte_typen->count() > 0)
			<div class="row d-flex align-items-center my-3">
				<div class="col-6">
					<h3 class="text-primary">Gelöschte Typen</h1>
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
									@foreach($geloeschte_typen as $lagertyp)
										<tr>
											<th scope="row">{{ $lagertyp->lagertyp_id }}</th>
											<td>{{ $lagertyp->name }}</td>
											<td>{{ date('d.m.Y H:i:s', strtotime($lagertyp->deleted_at)) }}</td>
											<td class="text-end">
												@include('components.iconbutton', [
													'color' => 'primary',
													'icon' => 'fa-trash-restore',
													'hovertext' => 'wiederherstellen',
													'url' => route('lager.typen.restore', ['id' => $lagertyp->lagertyp_id])
												])
												@include('components.iconbutton', [
													'color' => 'primary',
													'icon' => 'fa-trash',
													'hovertext' => 'für immer löschen',
													'url' => route('lager.typen.delete.permanent', ['id' => $lagertyp->lagertyp_id])
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
