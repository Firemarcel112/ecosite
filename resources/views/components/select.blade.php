<div class="form-floating {{ $classes ?? '' }}">
	<select class="{{ $select_classes ?? 'form-select' }}" id="{{ $id ?? $name }}" name="{{ $name ?? $id }}" aria-label="{{ $label ?? $placeholder ?? '' }}">
		@foreach($datas ?? [] as $data)
			<option @selected(old($name, $default_selected ?? null) == $data->{$data_value}) value={{ $data->{$data_value} }}>{{ $data->{$data_text ?? $data_value} }}</option>
		@endforeach
	</select>
	<label class="{{ $label_classes ?? 'form-label' }} @if ($required ?? false) required @endif" for="{{ $id ?? $name }}">{{ $label ?? $placeholder ?? '' }}</label>
</div>
