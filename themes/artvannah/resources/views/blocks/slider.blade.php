{{--
  Title: Slider
  Description: Slider section
  Category: template-blocks
  Icon: slides
  Post-Type: page post
  Keywords: slider
--}}

<section class="b-slider">
    <div class="container-fluid">
        <div class="row">
            <div class="col-24 col-md-22 m-auto">
                <div class="b-slider__wrapper">
                    @hasfield('items')
                    <div class="b-slider__images">
                        @foreach ($slides as $slide)
                            <div class="b-slider__image">
                                @include('elements.image', ['data' => $slide['image']])
                            </div>
                        @endforeach
                    </div>
                    @endfield
                    @hasfield('items')
                    <div class="b-slider__items u-relative u-h100 u-w100">
                        @foreach ($slides as $slide)
                            <div class="b-slider__item">
                                @if (!empty($slide['title']))
                                    <div class="b-slider__item-title">
                                        <h2>{{ $slide['title'] }}</h2>
                                    </div>
                                @endif

                                @if (!empty($slide['text']))
                                    <div class="b-slider__item-text">
                                        <p>{{ $slide['text'] }}</p>
                                    </div>
                                @endif

                                @if (!empty($slide['button']))
                                    <div class="b-slider__item-button">
                                        @include('elements.button', ['data' => $slide['button']])
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                    @endfield

                    <div class="b-slider__pagers u-pagers">
                        @include('elements.pager', [
                            'mode' => 'prev',
                            'class' => 'pager--white',
                        ])
                        @include('elements.pager', [
                            'mode' => 'next',
                            'class' => 'pager--white',
                        ])
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
