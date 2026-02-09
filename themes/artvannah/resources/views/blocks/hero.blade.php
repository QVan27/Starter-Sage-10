{{--
  Title: Hero
  Description: Hero section
  Category: template-blocks
  Icon: cover-image
  Post-Type: page
  Keywords: hero cover banner
--}}

<section class="b-hero u-overflow-clip">
    <div class="b-hero__image" data-parallax='1' data-offset="100%">
        @include('elements.image', ['data' => $image])
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-24 col-md-18 col-xl-10 offset-md-1">
                <div class="b-hero__content">
                    @include('components.classic-content', ['data' => $classicContent])
                </div>
            </div>
        </div>
    </div>
</section>
