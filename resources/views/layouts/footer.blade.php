<div class="container-fluid pt-4 px-4">
	<div class="bg-secondary rounded-top p-4">
		<div class="row">
			<div class="col-12 text-center text-sm-start d-sm-flex">
				<div class="col-12 col-sm-6">
					<i class="fa-solid fa-heart text-primary"></i> <a href="{{ route('startseite') }}">{{ config('app.name') }}</a> {{ date('Y') }}
				</div>
				<div class="col-12 col-sm-6 text-end">
					<span>Eco Server Version: {{ $server_info['Version'] ?? 0 }}</span>
				</div>
			</div>
		</div>
	</div>
</div>
</div>

<a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top">
	<i class="fa-regular fa-arrow-up"></i>
</a>
