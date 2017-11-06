@extends('front.layout')
@section('meta')

@if(!empty($single))
@if(trim(@$single->seo_judul) != '')
  <title>{{@$single->seo_judul}}</title>
@else
  <title>{{@$single->judul}}</title>
@endif
@if(trim(@$single->seo_deskripsi) != '')
  <meta name="description" content="<?= substr(strip_tags(@$single->seo_deskripsi), 0,300) ?>">
@else
  <meta name="description" content="<?= substr(strip_tags(@$single->deskripsi), 0,300) ?>">
@endif
@if(trim(@$single->seo_kata_kunci) != '')
  <meta name="keywords" content="{{@$single->seo_kata_kunci}}">
@else
  <meta name="keywords" content="{{@$single->judul}}">
@endif
  <meta name="author" content="{{$main['profile_website']->judul}}">

  <meta property="og:type"               content="article" />
@if(trim(@$single->seo_judul) != '')
  <meta property="og:title"              content="{{@$single->seo_judul}}" />
@else
  <meta property="og:title"              content="{{@$single->judul}}" />
@endif
@if(trim(@$single->seo_deskripsi) != '')
  <meta property="og:description"        content="<?= substr(strip_tags(@$single->seo_deskripsi), 0,300) ?>" />
@else
  <meta property="og:description"        content="<?= substr(strip_tags(@$single->deskripsi), 0,300) ?>" />
@endif
@if(trim(@$single->gambar) != '')
  <meta property="og:image"              content="{{asset('gambar').'/'.@$single->gambar}}" />
@else
  <meta property="og:image"              content="{{asset('gambar').'/'.$main['profile_website']->logo}}" />
@endif
  <meta property="og:image:width" content="500" />
  <meta property="og:image:height" content="450" />
  <meta property="og:site_name" content="{{$main['profile_website']->judul}}" />
  <meta property="og:url" content="{{Request::fullUrl()}}"/>
  
  <meta name="twitter:card" content="summary" />
@if(trim(@$single->seo_deskripsi) != '')
  <meta name="twitter:description" content="<?= substr(strip_tags(@$single->seo_deskripsi), 0,300) ?>" />
@else
  <meta name="twitter:description" content="<?= substr(strip_tags(@$single->deskripsi), 0,300) ?>" />
@endif
@if(trim(@$single->seo_judul) != '')
  <meta name="twitter:title" content="{{@$single->seo_judul}}" />
@else
  <meta name="twitter:title" content="{{@$single->judul}}" />
@endif
@if(trim(@$single->gambar) != '')
  <meta name="twitter:image" content="{{asset('gambar').'/'.@$single->gambar}}" />
@else
  <meta name="twitter:image" content="{{asset('gambar').'/'.$main['profile_website']->logo}}" />
@endif
@else

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
  <meta name="twitter:title" content="{{$main['profile_website']->seo_judul}}" />
@else
  <meta name="twitter:title" content="{{$main['profile_website']->judul}}" />
@endif
@if(trim($main['profile_website']->logo) != '')
  <meta name="twitter:image" content="{{asset('gambar').'/'.$main['profile_website']->logo}}" />
@else
  <meta name="twitter:image" content="{{asset('gambar').'/'.$main['profile_website']->gambar}}" />
@endif
@endif

@endsection
@section('script')
@endsection
@section('content')
@if(!empty($single))
<!-- Grid -->
<div class="w3-row " style="max-width:1200px;margin-top: 46px;margin:0 auto">
  <div class="w3-container w3-center w3-padding" style="margin-top: 50px"></div>
  <!-- Blog entries -->
  <div class="w3-col l7 s12">
    <h2 ><span class="w3-tag w3-light-grey w3-wide w3-card-2">{{@$single->judul}}</span></h2>    
    <div class="w3-col m12">
      <div class="w3-card-2 w3-round w3-white w3-margin">
        <div class="w3-container w3-padding-small">
          <small class="w3-text-grey">
          <a href="{{url()}}" title="{{$main['profile_website']->judul}}" >Home</a> /
          {{@$single->judul}}
          </small>
        </div>
      </div>
    </div>
    <!-- Blog entry -->
    <div class="w3-container w3-white ">
      
      <div class="w3-left-align">
@if(@$single->gambar != '')
        <img src="{{asset('gambar').'/'.@$single->gambar}}" alt="{{@$single->judul}}" style="width: 100%">
@endif
        <p>
          <?= @$single->deskripsi ?>
        </p>
        
        <p class="w3-clear"></p>
        <br>
        
        <span class="w3-right">
          <span>Contact : </span>
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

@if($contacts->role != 0)
          <a href="{{$link}}" title="{{$contacts->judul}}" target="_blank"><img src="{{asset('gambar').'/'.$contacts->gambar}}" alt="{{$contacts->judul}}" width="35px"></a>
@endif
@endforeach
        </span>
        
      </div>
    </div>
    <hr>
    
    <!-- END BLOG ENTRIES -->
  </div>
  
  <div class="w3-col l1 w3-hide-medium w3-hide-small">
    <!-- Blog entry -->
    <div class="w3-container w3-white ">
      <div style="position: fixed;">
        <span class="w3-tag w3-black">Share:</span><br>
        <a href="mailto:?Subject={{@$single->judul}}&amp;Body={{@$single->judul}} {{url('').'/'.@$single->slug}}" target="_blank" style="background-color: #F14336" class="w3-bar-item w3-button"><img src="{{asset('front')}}/email.png" alt="email" width="25px"></a><br>
        <a href="whatsapp://send?text={{@$single->judul}} {{url('').'/'.@$single->slug}}" target="_blank" style="background-color: #65BC54" class="w3-bar-item w3-button"><img src="{{asset('front')}}/wa.png" alt="whatsapp" width="25px"></a><br>
        <a href="https://lineit.line.me/share/ui?url={{url('').'/'.@$single->slug}}" target="_blank" style="background-color: #3FD037" class="w3-bar-item w3-button"><img src="{{asset('front')}}/line.png" alt="line" width="25px"></a><br>
        <a href="http://www.facebook.com/sharer.php?u={{url('').'/'.@$single->slug}}" target="_blank" style="background-color: #3B5998" class="w3-bar-item w3-button"><img src="{{asset('front')}}/facebook.png" alt="facebook" width="25px"></a><br>
        <a href="https://twitter.com/share?url={{url('').'/'.@$single->slug}}&amp;text={{@$single->judul}}&amp;hashtags={{@$single->judul}}" target="_blank" style="background-color: #55ACEE" class="w3-bar-item w3-button"><img src="{{asset('front')}}/twitter.png" alt="twitter" width="25px"></a><br>
      </div>
    </div>
  </div>
  <div class="w3-bottom w3-hide-large">
    <div class="w3-bar w3-black w3-center ">
      
      
      <a href="mailto:?Subject={{@$single->judul}}&amp;Body={{@$single->judul}} {{url('').'/'.@$single->slug}}" target="_blank" style="width:20%;background-color: #F14336" class="w3-bar-item w3-button"><img src="{{asset('front')}}/email.png" alt="email" width="25px"></a>
      <a href="whatsapp://send?text={{@$single->judul}} {{url('').'/'.@$single->slug}}" target="_blank" style="width:20%;background-color: #65BC54" class="w3-bar-item w3-button"><img src="{{asset('front')}}/wa.png" alt="whatsapp" width="25px"></a>
      <a href="https://lineit.line.me/share/ui?url={{url('').'/'.@$single->slug}}" target="_blank" style="width:20%;background-color: #3FD037" class="w3-bar-item w3-button"><img src="{{asset('front')}}/line.png" alt="line" width="25px"></a>
      <a href="http://www.facebook.com/sharer.php?u={{url('').'/'.@$single->slug}}" target="_blank" style="width:20%;background-color: #3B5998" class="w3-bar-item w3-button"><img src="{{asset('front')}}/facebook.png" alt="facebook" width="25px"></a>
      <a href="https://twitter.com/share?url={{url('').'/'.@$single->slug}}&amp;text={{@$single->judul}}&amp;hashtags={{@$single->judul}}" target="_blank" style="width:20%;background-color: #55ACEE" class="w3-bar-item w3-button"><img src="{{asset('front')}}/twitter.png" alt="twitter" width="25px"></a>
      
      
    </div>
  </div>
  
  @include('front.inc.sidebar')
  <!-- END GRID -->
</div>
@else
<!-- Grid -->
<div class="w3-row " style="max-width:1200px;margin-top: 46px;margin:0 auto">
  <div class="w3-container w3-center w3-padding" style="margin-top: 50px"></div>
  <!-- Blog entries -->
  <div class="w3-col l8 s12">
    
    <!-- Blog entry -->
    <div class="w3-container w3-white ">
      
      <div class="w3-left-align">
        <h1>Error 404</h1>
        <h2>Page Not Found!!</h2>
        <form method="get" action="{{url('search')}}">
          <input type="text"  name="search" placeholder="Search.." style="width: 100%;border: 3px solid #e0e0e0;padding: 10px;">
        </form>
      </div>
    </div>
    <hr>
    
    <!-- END BLOG ENTRIES -->
  </div> 
  @include('front.inc.sidebar')
  <!-- END GRID -->
</div>
@endif
@endsection