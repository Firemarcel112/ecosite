<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	@include('layouts.head')
<body>
	<div class="container-fluid position-relative d-flex p-0">
		@include('components.spinner')


		@include('layouts.sidebar')
		<div class="content">

			@include('layouts.navigation')
				<div class="container-fluid pt-4 px-4">
					@if(is_null($server_info))
						<div class="alert alert-danger fade show" role="alert">
							SERVER IST OFFLINE
						</div>
					@endif
					@include('layouts.alerts')
				</div>
				@yield('content')
				@include('layouts.footer')
		</div>
	</div>

	<!-- JavaScript Libraries -->
	<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
	<script src="{{ asset('lib/chart/chart.min.js') }}"></script>
	<script src="{{ asset('lib/easing/easing.min.js') }}"></script>
	<script src="{{ asset('lib/waypoints/waypoints.min.js') }}"></script>
	<script src="{{ asset('lib/owlcarousel/owl.carousel.min.js') }}"></script>
	<script src="{{ asset('lib/tempusdominus/js/moment.min.js') }}"></script>
	<script src="{{ asset('lib/tempusdominus/js/moment-timezone.min.js') }}"></script>
	<script src="{{ asset('lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js') }}"></script>

	<!-- Template Javascript -->
	<script src="{{ asset('js/main.js') }}"></script>
</body >
</html>

