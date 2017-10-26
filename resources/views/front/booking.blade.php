@extends('front.layout')
@section('meta')

@if(trim($main['profile_website']->seo_judul) != '')
  <title>Booking - {{$main['profile_website']->seo_judul}}</title>
@else
  <title>Booking - {{$main['profile_website']->judul}}</title>
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
<script src="{{asset('front')}}/jquery-3.1.1.min.js" type="text/javascript" ></script>
<script>
$(document).ready(function() {

$('#add').click(function() {
$('#input_add').append('<p><input class="w3-input w3-padding-16 w3-border" id="custom" name="custom_tour[]" type="text" placeholder="Your Tour" ></p>');
});
});
</script>
@endsection
@section('content')
<!-- Grid -->
<div class="w3-row " style="max-width:1200px;margin-top: 46px;margin:0 auto">
  <div class="w3-container w3-center w3-padding" style="margin-top: 50px"></div>
  <!-- Blog entries -->
  <div class="w3-col l8 s12">
@if (Session::has('msg'))
    <div class="alert alert-info">{{ Session::get('msg') }}</div>
@endif
    <form action="{{ url('booking') }}" method="POST" enctype="multipart/form-data" >
      {{ csrf_field() }}
      <h1 class="w3-padding"> Book Your Tour</h1>
      <div class="w3-col m12 w3-margin-bottom">
        <div class="w3-card-2 w3-round w3-white w3-margin">
          <div class="w3-container w3-padding-small">
            <small class="w3-text-grey">
            <a href="{{url()}}" title="{{$main['profile_website']->judul}}" >Home</a> /
            booking
            </small>
          </div>
        </div>
      </div>
      <!-- Blog entry -->
      <div class="w3-row-padding" style="max-width:1100px;margin-top: 46px;margin:0 auto; padding-bottom: 50px;">
        <div class="w3-row-padding ">
          <div class="w3-light-grey w3-card-2 " style="bottom: 15px;position: relative;">
            <h3 style="text-align: center">Select Tour</h3>
          </div>
          <div class="w3-col l12">
@foreach($product as $key)
@if($key['data'] != null)
            <div class="tab w3-round">
              <input id="{{$key['slug']}}" type="radio" name="tabs" class="acordion">
              <label for="{{$key['slug']}}">{{$key['name']}}</label>
              <div class="tab-content">
                @foreach($key['data'] as $row)
                <p><input class="w3-check" type="checkbox" value="{{$row->judul}}" name="tour[]"> <span>{{$row->judul}}</span></p>
@endforeach
              </div>
            </div>
@endif
@endforeach
          </div>
        </div>
        <hr>
        <div class="w3-row-padding ">
          <div class="w3-light-grey w3-card-4">
            <h3 style="text-align: center">Or Custom Tour</h3>
          </div>
          
          <div class="w3-row-padding">
            
            <div class="w3-col l12 m12 " id="input_add">
              <p><input class="w3-input w3-padding-16 w3-border" id="custom" name="custom_tour[]" type="text" placeholder="Your Tour" ></p>
            </div>
            <button class="w3-button w3-black" id="add">Add</button>
          </div>
          
        </div>
        <hr>
        
        <div class="w3-row-padding  ">
          
          <div class="w3-dark-grey w3-card-4">
            <h3 style="text-align: center">Send Booking</h3>
          </div>
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
              <p><input class="w3-input w3-padding-16 w3-border" type="text" placeholder="Message " required="" name="message"></p>
            </div>
            <div class="w3-col l12 m12  ">
              <div class="g-recaptcha" data-sitekey="6LflSDQUAAAAAIK-23y9Vjpavb9wOTv5rfDGxQKT"></div>
            </div>
            <div class="w3-col l12 m12  ">
              <p><button class="w3-button w3-black" type="submit">SEND BOOKING</button></p>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
  
  
  
@include('front.inc.sidebar')
  <!-- END GRID -->
</div>
@endsection