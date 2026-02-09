<article data-taxi-view data-mode="{{ get_field('h_mode') }}">
    <div class="single single-post">
        <section class="post-hero">
            <div class="container-fluid">
                <div class="row flex-lg-row-reverse justify-content-lg-end align-items-lg-start">
                    <div class="col-24 col-md-22 offset-md-1 col-lg-3 offset-xl-7">
                        <div class="post-hero__category">
                            <span class="u-font-mono -tag u-upper">@category</span>
                        </div>
                    </div>
                    <div class="col-24 col-md-22 offset-md-1 col-lg-18 col-xl-12">
                        <div class="post-hero__content">
                            <h1 class="post-hero__title">@title</h1>
                            <div class="post-hero__excerpt">@excerpt</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="post-hero__image">
                @include('elements.image', ['data' => $image])
            </div>
        </section>
        <section class="post-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-24 col-md-22 col-lg-20 col-xl-18 m-auto">
                        @content
                    </div>
                </div>
            </div>
        </section>
    </div>
</article>
