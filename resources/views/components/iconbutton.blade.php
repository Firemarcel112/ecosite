<a onclick="" @if(!empty($url)) href="{{ $url ?? '' }}" @endif class="btn btn-{{ $color ?? 'primary' }} {{ $classes ?? '' }}"
	{{ $extra_attributes ?? '' }}>
	<i class="fas {{ $icon ?? 'fa-edit' }}"
	@if(!empty($hovertext))
		data-bs-trigger="hover"
		data-bs-toggle="popover"
		data-bs-placement="top"
		data-bs-content="{{ $hovertext }}"
	@endif></i>
	@if(!empty($text))
		<span>{{ $text }}</span>
	@endif
</a>
