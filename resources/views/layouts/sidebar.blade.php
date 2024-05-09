<div class="sidebar pe-4 pb-3">
	<nav class="navbar bg-secondary navbar-dark">
		<a href="index.html" class="navbar-brand mx-4 mb-3">
			<h3 class="text-primary">
				{{ config('app.name') }}
			</h3>
		</a>
		<div class="d-flex align-items-center ms-4 mb-4">
			<div class="position-relative">
				<img class="rounded-circle" src="{{ auth()->user()?->profilbild?? '' }}" alt="{{ substr(auth()->user()->username, 0, 2) }}" style="width: 40px; height: 40px;">
				<div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
			</div>
			<div class="ms-3">
				<h6 class="mb-0">{{ auth()->user()->username }}</h6>
			</div>
		</div>
		<div class="navbar-nav w-100">
			<a href="{{ route('startseite') }}" class="nav-item nav-link @if(request()->is('/')) active @endif">
				<i class="fa fa-tachometer-alt me-2"></i>
				Startseite
			</a>
			<div class="nav-item dropdown">
				<a href="#" class="nav-link dropdown-toggle @if(request()->is('lager/*') || request()->is('lager')) active @endif" data-bs-toggle="dropdown">
					<i class="fa fa-th me-2"></i>
					Lager
				</a>
				<div class="dropdown-menu bg-transparent border-0">
					<a href="{{ route('lager.index') }}" class="dropdown-item @if(request()->is('lager')) active text-danger @endif">Übersicht</a>
					<a href="{{ route('lager.orte.index') }}" class="dropdown-item @if(request()->is('lager/orte')) active text-danger @endif">Lagerorte</a>
					<a href="{{ route('lager.typen.index') }}" class="dropdown-item @if(request()->is('lager/typen')) active text-danger @endif">Lagertypen</a>
				</div>
			</div>
			<div class="nav-item">
				<a href="{{ route('gegenstaende.index') }}" class="nav-link @if(request()->is('gegenstaende')) active @endif">
					<i class="fa fa-th me-2"></i>
					Gegenstände
				</a>
			</div>
			<div class="nav-item">
				<a href="{{ route('stack.index') }}" class="nav-link @if(request()->is('stack')) active @endif">
					<i class="fa fa-th me-2"></i>
					Stackverzeichnis
				</a>
			</div>
			<div class="nav-item">
				<a href="{{ env('ECO_API_URL') }}" target="_blank" class="nav-link">
					@include('components.icon', [
						'prefix' => 'fa-solid',
						'icon' => 'fa-globe',
						'classes' => 'me-2',
 					])
					ECO UI
				</a>
			</div>
		</div>
	</nav>
</div>
