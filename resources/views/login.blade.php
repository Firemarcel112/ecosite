@extends('layouts.login')

@section('content')
	<div class="container-fluid position-relative d-flex p-0">
		@include('components.spinner')
		<div class="container-fluid">
			<div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
				<div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
					@include('layouts.alerts')
					<form action="{{ route('userlogin') }}" class="bg-secondary rounded p-4 p-sm-5 my-4 mx-3">
						@csrf
						<div class="d-flex align-items-center justify-content-between mb-3">
							<a href="{{ route('login') }}" class="">
								<h3 class="text-primary"><i class="fa fa-user-edit me-2"></i>Eco Verwaltung</h3>
							</a>
							<h3>Einloggen</h3>
						</div>
						@include('components.input', [
							'classes' => 'mb-3',
							'id' => 'username',
							'name' => 'username',
							'placeholder' => 'Benutzername',
						])
						@include('components.input', [
							'classes' => 'mb-4',
							'id' => 'passwort',
							'name' => 'password',
							'placeholder' => 'Passwort',
							'type' => 'password',
						])
						<button type="submit" class="btn btn-primary py-3 w-100 mb-4">Einloggen</button>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection
