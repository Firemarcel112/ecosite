@php
	$type = $type ?? 'text';
	$value = $value ?? old($name) ?? '';
@endphp
@if($type == 'textarea')
	<div class="form-floating {{ $classes ?? '' }}">
		<textarea
			class="{{ $input_classes ?? 'form-control' }}" id="{{ $id ?? $name }}"
			name="{{ $name }}"
			@required($required ?? false)
			{{ $extra_attributes ?? '' }}>{{ $value ?? old($name) ?? '' }}</textarea>
		<label class="{{ $label_classes ?? 'form-label' }} @if($required ?? false) required @endif" for="{{ $id ?? $name }}">{{ $label ?? $placeholder ?? '' }}</label>
	</div>
@else
<div class="form-floating {{ $classes ?? '' }}">
	<input
		class="{{ $input_classes ?? 'form-control' }}" id="{{ $id ?? $name }}"
		type="{{ $type }}"
		name="{{ $name }}"
		placeholder="{{ $placeholder ?? '' }}"
		value="{{ $value }}"
		@required($required ?? false)
		{{ $extra_attributes ?? '' }}
		>
	<label class="{{ $label_classes ?? 'form-label' }} @if($required ?? false) required @endif" for="{{ $id ?? $name }}">{{ $label ?? $placeholder ?? '' }}</label>
</div>
@endif
