@extends('front.layout')
@section('meta')

@if(trim($seo->seo_judul) != '')
@if($list->currentPage() == 1)  
  <title>Tag - {{$seo->seo_judul}} }}</title>
@else
  <title>Tag - {{$seo->seo_judul}} - Page{{$list->currentPage()}}</title>
@endif
@else
@if($list->currentPage() == 1)  
  <title>Tag - {{$seo->judul}}</title>
@else
  <title>Tag - {{$seo->judul}} - Page{{$list->currentPage()}}</title>
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
@if(trim($main['profile_website']->logo) != '')
  <meta name="twitter:description" content="{{$seo->judul}} - <?= substr(strip_tags($seo->seo_deskripsi), 0,300) ?>" />
@else
  <meta name="twitter:description" content="{{$seo->judul}} - <?= substr(strip_tags($main['profile_website']->deskripsi), 0,300) ?>" />
@endif
@if(trim($seo->seo_judul) != '')
  <meta name="twitter:title" content="{{$seo->seo_judul}}" />
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
@endsection
@section('content')
<!-- Grid -->
<div class="w3-row " style="max-width:1200px;margin-top: 46px;margin:0 auto">
  <div class="w3-container w3-center w3-padding" style="margin-top: 50px"></div>
  <!-- Blog entries -->
  <div class="w3-col l8 s12">
    <h1 class="w3-center w3-padding "><span class="w3-tag w3-light-grey w3-wide w3-card-2">
      {{@$seo->judul}}
    </span></h1>
    <div class="w3-col m12">
      <div class="w3-card-2 w3-round w3-white w3-margin">
        <div class="w3-container w3-padding-small">
          <small class="w3-text-grey">
          <a href="{{url()}}" title="{{$main['profile_website']->judul}}" >Home</a> / Tag /
          {{@$seo->judul}}
          </small>
        </div>
      </div>
    </div>
    <div class="w3-row-padding " style="max-width:1100px;margin-top: 46px;margin:0 auto; padding-bottom: 50px;">
@foreach($list as $row)
@if($row->judul_product == '')
      <div class="w3-col l6 m6 w3-margin-bottom ">
        <div class="w3-card-4">
          <div class="w3-display-container">            
            <img src="{{url('gambar/thumb/'.$row->gambar_blog)}}" alt="{{$row->judul_blog}}" style="width:100%">            
            <div class="w3-padding">
              <h3 style="height: 70px">{{$row->judul_blog}}</h3>
              <p style="height: 100px">{{ substr(strip_tags($row->deskripsi_blog), 0,150)}}..</p>
              <p style="text-align: right;"><a href="{{url('blog/'.$row->slug_blog)}}" title="{{$row->judul_blog}}" class="w3-button w3-black ">Read More </a></p>              
            </div>            
          </div>
        </div>
          
      </div>
      

@elseif($row->judul_blog == '')
      <div class="w3-col l6 m6 w3-margin-bottom ">
        <div class="w3-card-4">
          <div class="w3-display-container">            
            <img src="{{url('gambar/thumb/'.$row->gambar_product)}}" alt="{{$row->judul_product}}" style="width:100%">           
            <div class="w3-padding">
              <h3 style="height: 70px">{{$row->judul_product}}</h3>
              <p style="height: 100px">{{ substr(strip_tags($row->deskripsi_product), 0,150)}}..</p>
              <p style="text-align: right;"><a href="{{url('link/'.$row->slug_product)}}" title="{{$row->judul_product}}" class="w3-button w3-black">Read More </a></p>              
            </div>
          </div>
        </div>
      </div>
@endif
@endforeach
      
    </div>
      <div class="w3-center w3-padding-32">  
        <?php echo $list->render(); ?>                
      </div>
    </div> 
 
  
@include('front.inc.sidebar')
  <!-- END GRID -->
</div>
@endsection