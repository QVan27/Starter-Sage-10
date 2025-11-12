{{--
  Title: Content Image
  Description: Content Image section
  Category: template-blocks
  Icon: columns
  Post-Type: page
  Keywords: content image
--}}

<section class="b-content-image">
    <div class="container-fluid">
        <div class="row align-items-xl-end">
            <div class="col-24 offset-md-1 col-md-22 col-xl-10">
                <div class="b-content-image__content">
                    @include('components.classic-content', [
                        'data' => $classicContent,
                        'color' => 'dark',
                    ])
                </div>
            </div>
            <div class="col-24 offset-md-1 col-md-22 col-xl-11">
                <div class="b-content-image__image">
                    @include('elements.image', ['data' => $image])
                </div>
            </div>
        </div>
    </div>
</section>
