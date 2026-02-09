<article class="c-post-card">
    <a href="{{ $data['link'] }}" class="c-post-card__link">
        @if (!empty($data['image']))
            <div class="c-post-card__image">
                @include('elements.image', ['data' => $data['image']])
            </div>
        @endif
        <div class="c-post-card__header u-font-tag-bold">
            @if (!empty($data['category']))
                <span class="u-font-mono -tag u-upper c-post-card__category">{{ $data['category'] }}</span>
            @endif
            @if (!empty($data['date']))
                <time class="c-post-card__date" datetime="{{ get_post_time('c', $post->ID ?? 0) }}">
                    {{ $data['date'] }}
                </time>
            @endif
        </div>
        <h3 class="c-post-card__title">{{ $data['title'] }}</h3>
        @if (!empty($data['excerpt']))
            <p class="c-post-card__excerpt">{{ $data['excerpt'] }}</p>
        @endif
    </a>
</article>
