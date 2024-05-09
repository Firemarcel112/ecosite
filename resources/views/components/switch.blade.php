@php
    $checked_value = isset($checked_value) ? $checked_value : $value;
@endphp
<div class="form-check form-switch {{ $classes ?? '' }}">
	<input
		class="form-check-input {{ $input_classes ?? '' }}" id="{{ $id ?? $name }}"
		type="{{ $type ?? 'checkbox' }}"
		name="{{ $name }}"
		placeholder="{{ $placeholder ?? '' }}"
		value="{{ $value }}"
		@required($required ?? false)
		@checked(old($name , 1) == $checked_value)
		>
	<label class="{{ $label_classes ?? 'form-check-label' }} @if($required ?? false) required @endif" for="{{ $id ?? $name }}">{{ $label ?? $placeholder ?? '' }}</label>
</div>
