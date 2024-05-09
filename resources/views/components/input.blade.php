<div class="form-floating {{ $classes ?? '' }}">
	<input
		class="{{ $input_classes ?? 'form-control' }}" id="{{ $id ?? $name }}"
		type="{{ $type ?? 'text' }}"
		name="{{ $name }}"
		placeholder="{{ $placeholder ?? '' }}"
		value="{{ $value ?? old($name) ?? '' }}"
		@required($required ?? false)
		>
	<label class="{{ $label_classes ?? 'form-label' }} @if($required ?? false) required @endif" for="{{ $id ?? $name }}">{{ $label ?? $placeholder ?? '' }}</label>
</div>
