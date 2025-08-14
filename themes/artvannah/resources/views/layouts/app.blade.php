<!doctype html>
<html @php(language_attributes())>
@include('partials.head')

<body class="{{ $form_submit_class }}">
    @php(wp_body_open())

    <div class="app">
        @php(do_action('get_header'))

        @include('partials.header')

        @if ($App['debug'])
            @include('partials.grid')
        @endif

        <main class="content" data-taxi role="document">
            @yield('content')
        </main>

        <div class="panel"></div>

        @include('partials.footer')

        @php(do_action('get_footer'))
        @php(wp_footer())
    </div>
</body>

</html>
