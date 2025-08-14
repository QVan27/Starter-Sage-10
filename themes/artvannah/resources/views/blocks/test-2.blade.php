{{--
  Title: test 2
  Description: Description of test
  Category: template-blocks
  Icon: hammer
  Post-Type: page post
  Keywords: test 2
--}}

<section class="b-test-2">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 m-auto">
                <h1>@field('title')</h1>
                <p>@field('text')</p>
                <div>@field('richtext')</div>
                <ul>
                    @fields('list')
                        <li>@sub('item')</li>
                    @endfields
                </ul>
            </div>
        </div>
    </div>
</section>
