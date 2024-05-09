@extends('layouts.app')

@section('content')
	<div class="modal fade" id="new-stack" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content bg-secondary">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Stack hinzufügen</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form method="POST" action="{{ route('stack.store') }}">
					@csrf
					<div class="modal-body">
						@include('components.select', [
							'name' => 'gegenstand_id',
							'label' => 'Gegenstand auswählen',
							'required' => true,
							'datas' => $gegenstaende,
							'data_value' => 'gegenstand_id',
							'data_text' => 'name',
						])
						@include('components.select', [
							'classes' => 'my-2',
							'name' => 'lagertyp_id',
							'label' => 'Lager auswählen',
							'required' => true,
							'datas' => $lagertyp,
							'data_value' => 'lagertyp_id',
							'data_text' => 'name',
						])
						@include('components.input', [
							'name' => 'anzahl',
							'label' => 'Anzahl',
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
				<h1 class="text-primary">Stackverzeichnis</h1>
			</div>
			<div class="col-6 text-end">
				@include('components.iconbutton', [
					'icon' => 'fa-plus',
					'text' => 'Stack hinzufügen',
					'url' => 'javascript:;',
					'extra_attributes' => 'data-bs-toggle=modal data-bs-target=#new-stack'
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
									<th scope="col">Lagertyp</th>
									<th scope="col">Gegenstand</th>
									<th scope="col">Stack Anzahl</th>
									<th scope="col"></th>
								</tr>
							</thead>
							<tbody>
								@forelse($stacks as $stack)
									<tr>
										<th scope="row">{{ $stack->gegenstand_stack_id }}</th>
										<td>{{ $stack->lagertyp->name }}</td>
										<td>{{ $stack->gegenstand->name }}</td>
										<td >{{ $stack->anzahl }}</td>
										<td class="text-end">
											@include('components.iconbutton', [
												'color' => 'primary',
												'icon' => 'fa-edit',
												'hovertext' => 'bearbeiten',
												'extra_attributes' => "data-bs-toggle=modal data-bs-target=#edit-stack-{$stack->gegenstand_stack_id}",
											])
											@include('components.iconbutton', [
												'color' => 'primary',
												'icon' => 'fa-trash',
												'hovertext' => 'löschen',
												'url' => route('stack.delete', ['id' => $stack->gegenstand_stack_id])
											])
										</td>
									</tr>
									<div class="modal fade" id="edit-stack-{{ $stack->gegenstand_stack_id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content bg-secondary">
												<div class="modal-header">
													<h5 class="modal-title" id="exampleModalLabel">Stack bearbeiten</h5>
													<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
												</div>
												<form method="POST" action="{{ route('stack.update', ['id' => $stack->gegenstand_stack_id]) }}">
													@csrf
													<div class="modal-body">
														@include('components.input', [
															'name' => 'anzahl',
															'label' => 'Anzahl',
															'required' => true,
															'type' => 'number',
															'value' => $stack->anzahl,
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
	</div>
@endsection
