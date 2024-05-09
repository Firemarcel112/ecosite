<i class="{{ $prefix ?? 'fas' }} {{ $icon }} {{ $classes ?? '' }}"
	@if(!empty($hovertext))
		data-bs-trigger="hover"
		data-bs-toggle="popover"
		data-bs-placement="top"
		data-bs-content="{{ $hovertext }}"
	@endif>
</i>
