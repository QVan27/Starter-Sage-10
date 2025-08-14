@php(do_action('get_footer'))

@include('elements/sprite')
<footer class="footer">
  <div class="container-fluid">
    <div class="row">
      <div class="col-auto">
        <div class="footer__links">
          @if (is_front_page())
            <div class="footer__links-credit">
              <a class="link" href="https://artvannah.fr/" target="_blank" rel="noopener">Création de site internet</a>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</footer>
