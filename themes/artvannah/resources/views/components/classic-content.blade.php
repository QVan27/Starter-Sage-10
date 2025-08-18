<div class="c-classic-content">
    @if (!empty($data['titles']))
        <div class="c-classic-content__title">
            @include('elements.title', ['data' => $data['titles']])
        </div>
    @endif

    @if (!empty($data['content']))
        <div class="c-classic-content__content">
            {!! wpautop($data['content']) !!}
        </div>
    @endif

    @if (!empty($data['button']))
        <div class="c-classic-content__button">
            @include('elements.button', ['data' => $data['button']])
        </div>
    @endif
</div>
