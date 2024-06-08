@extends('layouts.app')

@section('content')
	<div class="modal fade" id="new-aufgabe" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content bg-secondary">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Aufgabe hinzufügen</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form method="POST" action="{{ route('aufgaben.store') }}">
					@csrf
					<div class="modal-body">
						@include('components.input', [
							'name' => 'titel',
							'label' => 'Titel',
							'required' => true,
						])
						@include('components.input', [
							'classes' => 'mt-2',
							'name' => 'beschreibung',
							'label' => 'Beschreibung',
							'type' => 'textarea',
							'extra_attributes' => 'style=height:200px'
						])
						@include('components.select', [
							'classes' => 'mt-2',
							'name' => 'zugewiesen_id',
							'label' => 'Zuweisen zu',
							'required' => true,
							'datas' => $user,
							'data_value' => 'id',
							'data_text' => 'username',
						])
						<div class="form-floating mt-2">
							<select class="form-select" id="priorisierung" name="priorisierung" aria-label="priorisierung">
								@foreach($priorisierung ?? [] as $value => $name)
									<option @selected($value == 2) value={{ $value }}>{{ $name }}</option>
								@endforeach
							</select>
							<label class="form-label" for="status">Priorität</label>
						</div>
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
				<h1 class="text-primary">Aufgaben</h1>
			</div>
			<div class="col-6 text-end">
				@include('components.iconbutton', [
					'icon' => 'fa-plus',
					'text' => 'Aufgabe hinzufügen',
					'url' => 'javascript:;',
					'extra_attributes' => 'data-bs-toggle=modal data-bs-target=#new-aufgabe'
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
									<th scope="col">Titel</th>
									<th scope="col">Status</th>
									<th scope="col">Priorität</th>
									<th scope="col">Zugewiesen zu</th>
									<th scope="col">Erstellt am</th>
									<th scope="col" colspan=2></th>
								</tr>
							</thead>
							<tbody>
								@forelse($aufgaben as $aufgabe)
									<tr>
										<th scope="row">{{ $aufgabe->aufgaben_id }}</th>
										<td>{{ $aufgabe->titel }}</td>
										<td>{!! ($aufgabe->getReadableStatus()) !!}</td>
										<td>{!! ($aufgabe->getReadablePrioritaet()) !!}</td>
										<td>{{ $aufgabe->zugewiesen()->first()->username }}</td>
										<td>{{ date('d.m.Y H:i:s', strtotime($aufgabe->created_at)) }}</td>
										<td class="text-end">
											@include('components.iconbutton', [
												'color' => 'primary',
												'icon' => 'fa-eye',
												'hovertext' => 'Aufgabe anzeigen',
												'url' => route('aufgaben.show', ['id' => $aufgabe->aufgaben_id])
											])
											@include('components.iconbutton', [
												'color' => 'primary',
												'icon' => 'fa-edit',
												'hovertext' => 'bearbeiten',
												'extra_attributes' => "data-bs-toggle=modal data-bs-target=#edit-aufgabe-{$aufgabe->aufgaben_id}",
											])
										</td>
									</tr>
									<div class="modal fade" id="edit-aufgabe-{{ $aufgabe->aufgaben_id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content bg-secondary">
												<div class="modal-header">
													<h5 class="modal-title" id="exampleModalLabel">Aufgabe bearbeiten</h5>
													<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
												</div>
												<form method="POST" action="{{ route('aufgaben.update', ['id' => $aufgabe->aufgaben_id]) }}">
													@csrf
													<div class="modal-body">
														@include('components.input', [
															'name' => 'titel',
															'label' => 'Titel',
															'required' => true,
															'value' => $aufgabe->titel,
														])
														@include('components.input', [
															'classes' => 'mt-2',
															'name' => 'beschreibung',
															'label' => 'Beschreibung',
															'type' => 'textarea',
															'extra_attributes' => 'style=height:200px',
															'value' => $aufgabe->beschreibung
														])
														@include('components.select', [
															'classes' => 'mt-2',
															'name' => 'zugewiesen_id',
															'label' => 'Zuweisen zu',
															'required' => true,
															'datas' => $user,
															'data_value' => 'id',
															'data_text' => 'username',
															'default_selected' => $aufgabe->zugewiesen_id,
														])
														<div class="form-floating mt-2">
															<select class="form-select" id="status" name="status" aria-label="status">
																@foreach($status ?? [] as $value => $name)
																	<option @selected(old($name, $aufgabe->status ?? null) == $value) value={{ $value }}>{{ $name }}</option>
																@endforeach
															</select>
															<label class="'form-label'" for="status">Status</label>
														</div>
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
	</div>
@endsection
