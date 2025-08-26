@extends('layouts.app')

@section('content')
  <div data-taxi-view data-mode="{{ get_field('h_mode') }}">
    <div class="home">
      @php(the_content())
    </div>
  </div>
@endsection
