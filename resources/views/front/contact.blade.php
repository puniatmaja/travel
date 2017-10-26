@extends('front.layout')
@section('meta')
@if(trim($main['profile_website']->seo_judul) != '')

  <title>Contact - {{$main['profile_website']->seo_judul}}</title>
@else
  <title>Contact - {{$main['profile_website']->judul}}</title>
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
<!-- Grid -->
<div class="w3-row " style="max-width:1200px;margin-top: 46px;margin:0 auto">
  <div class="w3-container w3-center w3-padding" style="margin-top: 50px"></div>
  <!-- Blog entries -->
  <div class="w3-col l8 s12">
    <h2 ><span class="w3-tag w3-light-grey w3-wide w3-card-2">Contact</span></h2>
    <div class="w3-col m12">
      <div class="w3-card-2 w3-round w3-white w3-margin">
        <div class="w3-container w3-padding-small">
          <small class="w3-text-grey">
          <a href="{{url()}}" title="{{$main['profile_website']->judul}}" >Home</a> /
          contact
          </small>
        </div>
      </div>
    </div>
    <!-- Blog entry -->
    <div class="w3-container w3-white ">      
@if(trim($main['profile_website']->map) != '')
      <?= $main['profile_website']->map;  ?>
@endif
      <div class="w3-left-align">
@if(trim($main['profile_website']->logo) != '')
        <div class="w3-col l3 s12">
          <a href="{{url('/')}}" title="{{$main['profile_website']->judul}}"><img src="{{url('gambar').'/'.$main['profile_website']->logo}}" alt="logo" width="120px"></a>
        </div>
        <div class="w3-col l9 s12">          
          <p>Address : {{$main['profile_website']->alamat}}</p>
          <br>
@foreach($main['contact'] as $contact)
@if($contact->gambar != '')
          <img src="{{asset('gambar').'/'.$contact->gambar}}" alt="{{$contact->judul}}" width="30px">
@endif
          {{$contact->judul}} : {{$contact->kontak}}<br>
@endforeach
          <hr>
@foreach($main['social_media'] as $social_media)
          <a href="{{$social_media->link}}" title="{{$social_media->judul}}"><img src="{{asset('gambar').'/'.$social_media->gambar}}" alt="{{$social_media->judul}}" width="40px"></a>
@endforeach
        </div>
@else
        <div class="w3-col l6 s12">          
          <p>Address : {{$main['profile_website']->alamat}}</p>                    
@foreach($main['contact'] as $contacts)

@if($contacts->role == 1)
<?php $link = 'mailto:'.$contacts->kontak; ?>
@elseif($contacts->role == 2)
<?php $link = 'tel:'.$contacts->kontak; ?>
@elseif($contacts->role == 3)
<?php $link = 'https://api.whatsapp.com/send?phone='.$contacts->kontak; ?>
@elseif($contacts->role == 4)
<?php $link = 'weixin://dl/chat?'.$contacts->kontak; ?>
@elseif($contacts->role == 5)
<?php $link = 'https://story.kakao.com/ch/'.$contacts->kontak; ?>
@elseif($contacts->role == 6)
<?php $link = 'viber://pa?chatURI='.$contacts->kontak; ?>
@endif
    <p>
@if($contacts->role != 0)
@if($contacts->gambar != '')
      <a href="{{$link}}" title="{{$contacts->judul}}" target="_blank"><img src="{{asset('gambar').'/'.$contacts->gambar}}" alt="{{$contacts->judul}}" width="30px"> </a>
@endif
    {{$contacts->judul}} : <a href="{{$link}}" title="{{$contacts->judul}}" target="_blank">{{$contacts->kontak}}</a></p>
@else

@if($contacts->gambar != '')
      <img src="{{asset('gambar').'/'.$contacts->gambar}}" alt="{{$contacts->judul}}" width="30px">
@endif
    {{$contacts->judul}} : {{$contacts->kontak}}</p>
@endif
@endforeach
          <hr>
@foreach($main['social_media'] as $social_media)
          <a href="{{$social_media->link}}" title="{{$social_media->judul}}"><img src="{{asset('gambar').'/'.$social_media->gambar}}" alt="{{$social_media->judul}}" width="40px"></a>
@endforeach
        </div>
@endif
        
        
        
        <p class="w3-clear"></p>
        <br>
        
      </div>
    </div>
    <hr>
    <div class="w3-row-padding  ">
@if (Session::has('msg'))
      <div class="alert alert-info">{{ Session::get('msg') }}</div>
@endif
      <div class="w3-dark-grey w3-card-4">
        <h3 style="text-align: center">Send Message</h3>
      </div>
      <form action="{{ url('contact') }}" method="POST" enctype="multipart/form-data" >
        {{ csrf_field() }}
        <div class="w3-row-padding">
          <div class="w3-col l6 m6  ">
            <p><input class="w3-input w3-padding-16 w3-border" type="text" placeholder="Your Name*" required="" name="name"></p>
          </div>
          <div class="w3-col l6 m6  ">
            <p><input class="w3-input w3-padding-16 w3-border" type="text" placeholder="Subject*" required="" name="subject"></p>
          </div>
          <div class="w3-col l12 m12  ">
            <p><input class="w3-input w3-padding-16 w3-border" type="email" placeholder="Your Email" required="" name="email"></p>
          </div>
          <div class="w3-col l12 m12  ">
            <p><input class="w3-input w3-padding-16 w3-border" type="text" placeholder="Message " required="" name="message"></p>
          </div>
          <div class="w3-col l12 m12  ">
            <div class="g-recaptcha" data-sitekey="6LflSDQUAAAAAIK-23y9Vjpavb9wOTv5rfDGxQKT"></div>
          </div>
          <div class="w3-col l12 m12  ">
            <p><button class="w3-button w3-black" type="submit">SEND</button></p>
          </div>
        </div>
      </form>
    </div>
    <!-- END BLOG ENTRIES -->
  </div>
  
  
  
@include('front.inc.sidebar')
  <!-- END GRID -->
</div>
@endsection