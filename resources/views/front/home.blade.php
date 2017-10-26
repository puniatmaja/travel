@extends('front.layout')
@section('meta')

@if(trim($main['profile_website']->seo_judul) != '')
  <title>{{$main['profile_website']->seo_judul}}</title>
@else
  <title>{{$main['profile_website']->judul}}</title>
@endif
@if(trim($main['profile_website']->seo_deskripsi) != '')
  <meta name="description" content="<?= substr(strip_tags($main['profile_website']->seo_deskripsi), 0,300) ?>">
@else
  <meta name="description" content="<?= substr(strip_tags($main['profile_website']->deskripsi), 0,300) ?>">
@endif
@if(trim($main['profile_website']->seo_kata_kunci) != '')
  <meta name="keywords" content="{{$main['profile_website']->seo_kata_kunci}}">
@else
  <meta name="keywords" content="{{$main['profile_website']->judul}}">
@endif
  <meta name="author" content="{{$main['profile_website']->judul}}">

  <meta property="og:type"               content="article" />
@if(trim($main['profile_website']->seo_judul) != '')
  <meta property="og:title"              content="{{$main['profile_website']->seo_judul}}" />
@else
  <meta property="og:title"              content="{{$main['profile_website']->judul}}" />
@endif
@if(trim($main['profile_website']->seo_deskripsi) != '')
  <meta property="og:description"        content="<?= substr(strip_tags($main['profile_website']->seo_deskripsi), 0,300) ?>" />
@else
  <meta property="og:description"        content="<?= substr(strip_tags($main['profile_website']->deskripsi), 0,300) ?>" />
@endif
@if(trim($main['profile_website']->logo) != '')
  <meta property="og:image"              content="{{asset('gambar').'/'.$main['profile_website']->logo}}" />
@else
  <meta property="og:image"              content="{{asset('gambar').'/'.$main['profile_website']->gambar}}" />
@endif
  <meta property="og:image:width" content="500" />
  <meta property="og:image:height" content="450" />
  <meta property="og:site_name" content="{{$main['profile_website']->judul}}" />
  <meta property="og:url" content="{{Request::fullUrl()}}"/>

  <meta name="twitter:card" content="summary" />
@if(trim($main['profile_website']->seo_deskripsi) != '')
  <meta name="twitter:description" content="<?= substr(strip_tags($main['profile_website']->seo_deskripsi), 0,300) ?>" />
@else
  <meta name="twitter:description" content="<?= substr(strip_tags($main['profile_website']->deskripsi), 0,300) ?>" />
@endif
@if(trim($main['profile_website']->seo_judul) != '')
  <meta name="twitter:title" content="{$main['profile_website']->seo_judul}}" />
@else
  <meta name="twitter:title" content="{{$main['profile_website']->judul}}" />
@endif
@if(trim($main['profile_website']->logo) != '')
  <meta name="twitter:image" content="{{asset('gambar').'/'.$main['profile_website']->logo}}" />
@else
  <meta name="twitter:image" content="{{asset('gambar').'/'.$main['profile_website']->gambar}}" />
@endif

@endsection
@section('script')
<script src='https://www.google.com/recaptcha/api.js'></script>
@endsection
@section('content')

@foreach($home as $row)
@if($row->name == 'Slider')
    @include('front.inc.slider')
@elseif($row->name == 'Profile')
   @include('front.inc.profile')
@elseif($row->name == 'Product')
   @include('front.inc.product')
@elseif($row->name == 'Special')
    @include('front.inc.special')

@endif
@endforeach

<section class="w3-row-padding" style="max-width:1100px;margin-top: 76px;margin:0 auto ; padding-top: 50px;padding-bottom: 50px">
@if (Session::has('msg'))
  <div class="alert alert-info">{{ Session::get('msg') }}</div>
@endif
  <div class="w3-dark-grey w3-card-4 ">
    <h3 style="text-align: center">Booking</h3>
  </div>
  <div class="w3-row-padding ">
    <form action="{{ url('home_booking') }}" method="POST" enctype="multipart/form-data" >
      {{ csrf_field() }}
      <div class="w3-row-padding">
        <div class="w3-col l6 m6  ">
          <p><input class="w3-input w3-padding-16 w3-border" type="text" placeholder="Your Name*" required="" name="name"></p>
        </div>
        <div class="w3-col l6 m6  ">
          <p><input class="w3-input w3-padding-16 w3-border" type="text" placeholder="Your Address / Hotel Address" required="" name="address"></p>
        </div>
        <div class="w3-col l12 m12  ">
          <p><input class="w3-input w3-padding-16 w3-border" type="email" placeholder="Your Email" required="" name="email"></p>
        </div>
        <div class="w3-col l6 m6  ">
          <p><input class="w3-input w3-padding-16 w3-border" type="text" placeholder="Your Hotel*" required="" name="hotel"></p>
        </div>
        <div class="w3-col l6 m6  ">
          <p><input class="w3-input w3-padding-16 w3-border" type="text" placeholder="Your Phone Number / Hotel Phone Number" required="" name="phone"></p>
        </div>
        <div class="w3-col l6 m6  ">
          <p><input class="w3-input w3-padding-16 w3-border" type="date" placeholder="Date" required="" name="date" value="<?= date('Y-m-d');  ?>"></p>
        </div>
        <div class="w3-col l3 m3  ">
          <p><input class="w3-input w3-padding-16 w3-border" type="number" min="0" placeholder="Child" required="" name="child" ></p>
        </div>
        <div class="w3-col l3 m3  ">
          <p><input class="w3-input w3-padding-16 w3-border" type="number" min="0" placeholder="Adult" required="" name="adult" ></p>
        </div>
        <div class="w3-col l12 m12  ">
          <p><input class="w3-input w3-padding-16 w3-border" type="text" placeholder="Your Tour" required="" name="custom_tour"></p>
        </div>
        <div class="w3-col l12 m12  ">
          <p><input class="w3-input w3-padding-16 w3-border" type="text" placeholder="Message " required="" name="message"></p>
        </div>
        <div class="w3-col l12 m12  ">
          <div class="g-recaptcha" data-sitekey="6LflSDQUAAAAAIK-23y9Vjpavb9wOTv5rfDGxQKT"></div>
        </div>
        <div class="w3-col l12 m12  ">
          <p><button class="w3-button w3-black" type="submit">SEND BOOKING</button></p>
        </div>
      </div>
    </form>
  </div>
  <hr>
</section>
@endsection