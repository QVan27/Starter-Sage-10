{{--
  Title: Formulaire de contact
  Description: Formulaire & informations de contact
  Category: template-blocks
  Icon: welcome-widgets-menus
  Post-Type: page
  Keywords: form formulaire contact
--}}

<section class="b-form">
    <div class="container-fluid">
        <div class="row u-margin">
            <div class="col-24 col-md-22 offset-md-1">
                @include('elements.title', ['data' => $titles])
            </div>
        </div>
        <div class="row">
            <div class="col-24 col-md-22 offset-md-1 col-lg-11 col-xl-8">
                <div class="b-form__content">
                    <h2>@field('second_title')</h2>
                    <h3>@field('third_title')</h3>
                    <p>@field('content')</p>
                    @hasfield('address')
                      <a class="u-underline-hover" href="{{ $address['url'] }}" @if ($address['target']) target="_blank" rel="noopener" @endif>{{ $address['title'] }}</a>
                    @endfield
                </div>
            </div>
            <div class="col-24 col-md-22 offset-md-1 col-lg-11 offset-lg-0 offset-xl-3">
                @include('components.form', ['id' => $id])
            </div>
        </div>
    </div>
</section>
