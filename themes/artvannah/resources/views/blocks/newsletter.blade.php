{{--
  Title: Newsletter
  Description: Newsletter section
  Category: template-blocks
  Icon: align-center
  Post-Type: page
  Keywords: newsletter
--}}

<section class="b-newsletter">
    <div class="container-fluid">
        <div class="row">
            <div class="col-24 m-auto col-md-22 col-lg-18 col-xl-10">
                <div class="b-newsletter__content">
                    @include('components.classic-content', [
                        'data' => $classicContent,
                        'class' => 'center u-text-center',
                    ])
                </div>
            </div>
        </div>
    </div>
</section>
