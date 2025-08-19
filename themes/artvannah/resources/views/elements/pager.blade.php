@php
    $class = isset($class) ? $class : '';
@endphp

<div class="pager pager--{{ $mode }} {{ $class }}">
    <span class="pager__arrow">{!! display_svg('arrow-right') !!}</span>
</div>
