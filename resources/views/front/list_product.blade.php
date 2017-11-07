@extends('front.layout')
@section('meta')
@if(!empty($seo))
@if(trim($seo->seo_judul) != '')
@if($list->currentPage() == 1)  
  <title>{{$seo->judul}} - {{$seo->seo_judul}}</title>  
@else
  <title>{{$seo->judul}} - {{$seo->seo_judul}} - Page{{$list->currentPage()}}</title>  
@endif  
@else
@if($list->currentPage() == 1)  
  <title>{{$seo->judul}} - {{$seo->judul}}</title>  
@else
  <title>{{$seo->judul}} - {{$seo->judul}} - Page{{$list->currentPage()}}</title>  
@endif  
@endif
@if(trim($seo->seo_deskripsi) != '')
  <meta name="description" content="{{$seo->judul}} - <?= substr(strip_tags($seo->seo_deskripsi), 0,300) ?>">
@else
  <meta name="description" content="{{$seo->judul}} - <?= substr(strip_tags($main['profile_website']->deskripsi), 0,300) ?>">
@endif
@if(trim($seo->seo_kata_kunci) != '')
  <meta name="keywords" content="{{$seo->seo_kata_kunci}}">
@else
  <meta name="keywords" content="{{$main['profile_website']->judul}}">
@endif
  <meta name="author" content="{{$main['profile_website']->judul}}">

  <meta property="og:type"               content="article" />
@if(trim($seo->seo_judul) != '')
  <meta property="og:title"              content="{{$seo->seo_judul}}" />
@else
  <meta property="og:title"              content="{{$main['profile_website']->judul}}" />
@endif
@if(trim($seo->seo_deskripsi) != '')
  <meta property="og:description"        content="{{$seo->judul}} - <?= substr(strip_tags($seo->seo_deskripsi), 0,300) ?>" />
@else
  <meta property="og:description"        content="{{$seo->judul}} - <?= substr(strip_tags($main['profile_website']->deskripsi), 0,300) ?>" />
@endif
@if(trim($seo->gambar) != '')
  <meta property="og:image"              content="{{asset('gambar').'/'.$seo->gambar}}" />
@else
  <meta property="og:image"              content="{{asset('gambar').'/'.$main['profile_website']->logo}}" />
@endif
  <meta property="og:image:width" content="500" />
  <meta property="og:image:height" content="450" />
  <meta property="og:site_name" content="{{$main['profile_website']->judul}}" />
  <meta property="og:url" content="{{Request::fullUrl()}}"/>
  
  <meta name="twitter:card" content="summary" />
@if(trim($seo->seo_deskripsi) != '')
  <meta name="twitter:description" content="{{$seo->judul}} - <?= substr(strip_tags($seo->seo_deskripsi), 0,300) ?>" />
@else
  <meta name="twitter:description" content="{{$seo->judul}} - <?= substr(strip_tags($main['profile_website']->deskripsi), 0,300) ?>" />
@endif
@if(trim($seo->seo_judul) != '')
  <meta name="twitter:title" content="{{$seo->seo_judul}}" />
@else
  <meta name="twitter:title" content="{{$main['profile_website']->judul}}" />
@endif
@if(trim($seo->gambar) != '')
  <meta name="twitter:image" content="{{asset('gambar').'/'.$seo->gambar}}" />
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
@if(!empty($seo))
<!-- Grid -->
<div class="w3-row " style="max-width:1200px;margin-top: 46px;margin:0 auto">
  <div class="w3-container w3-center w3-padding" style="margin-top: 50px"></div>
  <!-- Blog entries -->
  <div class="w3-col l8 s12">
    <h1 class="w3-center w3-padding "><span class="w3-tag w3-light-grey w3-wide w3-card-2">
@if($main['profile_website']->judul == $seo->judul)
      All Tour
@else
      {{@$seo->judul}}
@endif
    </span></h1>
    <div class="w3-col m12">
      <div class="w3-card-2 w3-round w3-white w3-margin">
        <div class="w3-container w3-padding-small">
          <small class="w3-text-grey">
          <a href="{{url()}}" title="{{$main['profile_website']->judul}}" >Home</a> /
@if($main['profile_website']->judul == $seo->judul)
          All Tour
@else
          {{@$seo->judul}}
@endif
          </small>
        </div>
      </div>
    </div>
    <div class="w3-row-padding " style="max-width:1100px;margin-top: 46px;margin:0 auto; padding-bottom: 50px;">
@foreach($list as $row)
      <div class="w3-col l6 m6 w3-margin-bottom ">
        <div class="w3-card-4">
          <div class="w3-display-container">
            <a href="{{url('link/'.$row->slug)}}" title="{{$row->judul}}">
              <img src="{{url('gambar/thumb/'.$row->gambar)}}" alt="{{$row->judul}}" style="width:100%">
            </a>
            <a href="{{url('link/'.$row->slug)}}" title="{{$row->judul}}">
              <div class="w3-display-bottommiddle w3-light-grey w3-block w3-padding-small"><h5>{{$row->judul}}</h5></div>
            </a>
          </div>
        </div>
      </div>
@endforeach
      
    </div>
    <div class="w3-center w3-padding-32">  
        <?php echo $list->render(); ?>        
      </div>    
    <!-- END BLOG ENTRIES -->
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