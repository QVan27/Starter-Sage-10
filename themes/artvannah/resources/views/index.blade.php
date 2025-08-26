@extends('layouts.app')

@section('content')
    <div data-taxi-view data-mode="{{ get_field('h_mode') }}">
        <div class="news">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-24 col-md-22 m-auto">
                        <div class="news__header u-margin">
                            <h1>{{ $title }}</h1>
                            {!! $content !!}
                        </div>
                        <div class="news__filters u-font-tag-bold">
                            <span>({{ $posts_count }} articles)</span>
                            <form method="GET">
                                <label for="category">Filtrer par catégorie :</label>
                                <select name="category" id="category" onchange="this.form.submit()">
                                    <option value="">Toutes</option>
                                    @foreach ($filters['terms'] as $term)
                                        <option value="{{ $term->term_id }}"
                                            {{ $filters['selected'] == $term->term_id ? 'selected' : '' }}>
                                            {{ $term->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </div>
                        <div class="news__posts">
                            @foreach ($posts as $post)
                                @include('components.post-card', ['data' => $post])
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="news__pagination">
                {!! posts_nav_link(' ', '<span class="prev">', '<span class="next">') !!}
            </div>
        </div>
    </div>
@endsection
