@php
  $args = $args ?? [];
@endphp

<div class="c-form">
    @php
        advanced_form(
            $id,
            array_merge(
                [
                    'submit_text' => __('Envoyer', 'artvannah'),
                    'ajax' => true,
                    'uploader' => 'basic',
                ],
                $args
            ),
        );
    @endphp
</div>
