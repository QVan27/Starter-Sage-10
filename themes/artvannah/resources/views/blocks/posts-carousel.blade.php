{{--
  Title: Posts Carousel
  Description: Posts Carousel section
  Category: template-blocks
  Icon: slides
  Post-Type: page
  Keywords: posts carousel
--}}

<section class="b-posts-carousel u-padding">
    <div class="container-fluid">
        <div class="row u-margin">
            <div class="col-24 col-md-22 offset-md-1">
                <div class="b-posts-carousel__head">
                    @include('elements.title', ['data' => $titles])
                    <div class="b-posts-carousel__button u-flex">
                        @include('elements.button', [
                            'data' => $button,
                            'color' => 'dark',
                        ])
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="b-posts-carousel__container u-nsb">
        <div class="b-posts-carousel__wrapper">
            @foreach ($posts as $post)
                <div class="b-posts-carousel__post">
                    @include('components.post-card', ['data' => $post])
                </div>
            @endforeach
        </div>
        <div class="b-posts-carousel__pagers u-pagers">
            @include('elements.pager', [
                'mode' => 'prev',
                'class' => 'dashed',
            ])
            @include('elements.pager', [
                'mode' => 'next',
                'class' => 'dashed',
            ])
        </div>
    </div>
</section>
