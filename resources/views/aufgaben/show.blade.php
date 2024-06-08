@extends('layouts.app')
@section('content')
	<div class="container-fluid pt-4 px-4">
		<div class="row d-flex align-items-center mb-3">
			<div class="col-12">
				<h1 class="text-primary">Aufgabe: {{ $aufgabe->titel }} für {{ $aufgabe->zugewiesen()->first()->username }} ({!! $aufgabe->getReadableStatus() !!})</h1>
			</div>
		</div>

		<div class="card text-primary bg-secondary">
			<div class="card-body">
				{{ $aufgabe->beschreibung }}
			</div>
		</div>

		<div class="mt-2">
			<h2>Kommentare:</h2>

			@foreach($aufgabe->kommentare as $kommentar)
				<div class="my-2 card bg-secondary">
					<div class="card-body">
						{{ $kommentar->text }}
					</div>
					<div class="card-footer text-end">
						von {{ $kommentar->user()->first()->username }} am {{ date('d.m.Y H:i:s', strtotime($kommentar->created_at)) }}
					</div>
				</div>
			@endforeach
		</div>

		<h2 class="mt-2">Kommentar verfassen:</h2>
		<div class="mt-1">
			<form method="POST" action="{{ route('aufgaben.comment') }}">
				<input type="hidden" value="{{ $aufgabe->aufgaben_id }}" name="aufgaben_id">
				@csrf
				@include('components.input', [
					'type' => 'textarea',
					'label' => 'Kommentar',
					'name' => 'kommentar',
					'extra_attributes' => 'style=height:200px',
					'classes' => 'mb-2'
				])
				<button type="submit" class="btn btn-primary">Senden</button>
			</form>
		</div>

	</div>
@endsection
