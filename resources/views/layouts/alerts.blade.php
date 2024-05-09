@php
	if(!empty(session('message')))
	{
		$message = session('message');
	}
	if(!empty(session('messages')))
	{
		$messages = session('messages');
	}
@endphp

@foreach($errors?->all() ?? [] as $error)
	<div class="alert alert-danger alert-dismissible fade show" role="alert">
			{{ $error }}
		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
	</div>
@endforeach
@forelse($messages ?? [] as $message)
	@if(!empty($message['typ']))
		@switch(strtolower($message['typ']))
			@case('error')
				@php $class = 'danger' @endphp
			@break
			@case('warning')
				@php $class = 'warning' @endphp
			@break
			@case('success')
				@php $class = 'success' @endphp
			@break
			@default
		@endswitch
	@endif
		<div class="alert alert-{{ $class ?? 'info' }} alert-dismissible fade show" role="alert">
			{{ $message['text'] }}
		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
	</div>
@empty
@endforelse
@if(!empty($message))
	@if(!empty($message['typ']))
		@switch(strtolower($message['typ']))
			@case('error')
				@php $class = 'danger' @endphp
			@break
			@case('warning')
				@php $class = 'warning' @endphp
			@break
			@case('success')
				@php $class = 'success' @endphp
			@break
			@default
		@endswitch
	@endif
		<div class="alert alert-{{ $class ?? 'info' }} alert-dismissible fade show" role="alert">
			{{ $message['text'] ?? $message }}
		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
	</div>
@endif
