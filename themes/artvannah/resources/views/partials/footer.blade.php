@php(do_action('get_footer'))

@include('elements/sprite')
<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-24 col-md-22 m-auto">
                <div class="footer__logo u-padding">
                    <a href="{{ home_url('/') }}" aria-label="Retour à l'accueil" role="link" tabindex="0">
                        {!! display_svg('logo') !!}
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>
