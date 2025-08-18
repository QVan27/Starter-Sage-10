@php
    $is_link = isset($is_link) ? $is_link : true;
    $color = isset($color) ? $color : '';
@endphp

@if ($is_link)
    <a class="button @if ($color) {{ $color }} @endif" href="{{ $data['url'] }}"
        @if ($data['target']) target="_blank" rel="noopener" @endif>
        {{ $data['title'] }}
    </a>
@else
    <div class="button @if ($color) {{ $color }} @endif">
        {{ $data['title'] }}
    </div>
@endif
