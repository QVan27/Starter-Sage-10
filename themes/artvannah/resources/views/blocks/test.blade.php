{{--
  Title: test
  Description: Description of test
  Category: template-blocks
  Icon: hammer
  Post-Type: page post
  Keywords: test
--}}

<section class="b-test">
    <h1>@field('title')</h1>
    <p>@field('text')</p>
    <div>@field('richtext')</div>
    <ul>
        @fields('list')
            <li>@sub('item')</li>
        @endfields
    </ul>
</section>
