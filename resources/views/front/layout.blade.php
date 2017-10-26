<!DOCTYPE html>
<html>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="theme-color" content="#38AA4B" />
  <meta name="apple-mobile-web-app-status-bar-style" content="#38AA4B">
@yield('meta')
  <link rel="icon" type="image/png" href="{{asset('gambar').'/'.$main['profile_website']->logo}}">
  <link rel="stylesheet" href="{{asset('front')}}/style.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="{{asset('front')}}/slider.css">
  <link rel="stylesheet" type="text/css" href="{{asset('front')}}/nav.css">
  <link rel="stylesheet" type="text/css" href="{{asset('front')}}/theme.css">
@if(trim($main['profile_website']->google_webmaster) != '')  
  <?= $main['profile_website']->google_webmaster; ?>  
@endif
@if(trim($main['profile_website']->google_analytics) != '')  
  <?= $main['profile_website']->google_analytics; ?>  
@endif
@if(trim($main['profile_website']->facebook_pixel) != '')  
  <?= $main['profile_website']->facebook_pixel; ?>  
@endif
  <style type="texx/css">
    body,h1,h2,h3,h4,h5,h6 {font-family: "Lato", sans-serif;}
  </style>
@yield('script')
<body>
<!-- Navbar -->
  <nav class="w3-top w3-black">
    
    <label for="show-menu" class="show-menu w3-card-2 w3-black ">Menu <img src="{{url('front')}}/menu.png" alt="Image" class="w3-left w3-margin-right" style="width:35px;padding: 10px 0 0 10px"></label>  
    <input type="checkbox" id="show-menu" role="button">
    <ul id="menu" class="w3-black w3-card-2 nav" style="width: 100%">
          <li style="float: right;" class="nav">
            <form method="get" action="{{url('search')}}">
              <input type="text" id="search" name="search" placeholder="Search..">
            </form>
          </li>
@foreach($main['menu'] as $row)
          <li class="nav">
@if($row->link == 'kategori')
            <a href="#" title="{{$row->judul}}">
@else
            <a href="{{$row->link}}" title="{{$row->judul}}">
@endif
              {{$row->judul}}
            </a>        
@if($row->link == 'kategori')    
              <ul class="hidden nav">
@foreach($main['parent'][$row->id_parent] as $key)
                    <li class="nav"><a href="{{url('link').'/'.$key->slug}}" title="{{$key->judul}}">{{$key->judul}}</a></li>
@endforeach                  
              </ul>
@endif
          </li>
@endforeach          
      </ul>
  </nav>
  <!-- Page content -->
  <section class="w3-content" style="max-width:1378px;margin-top: 46px">
@yield('content')
  </section>  

<!-- Footer -->  
  <div class="w3-dark-grey w3-padding-small w3-card-2" style="max-width:1100px;margin: 0 auto;position: relative;top: 20px;z-index: 100">
@foreach($main['menu_footer'] as $row)
     <a href="{{$row->link}}" title="{{$row->judul}}" style="color:#fff">{{$row->judul}}</a> /      
@endforeach
  </div>
  <footer class="w3-row-padding w3-padding-32" style="z-index: 99;position: relative;background-color: #efefef">
    <div style="max-width:1100px;margin-top: 76px;margin:0 auto;">      
      <div class="w3-third w3-padding-small">
@foreach($main['footer_kolom1'] as $row)
@if($row->role == 1)
@include('front.footer.sosial_media')
@elseif($row->role == 2)
@include('front.footer.kontak')
@elseif($row->role == 3)
@include('front.footer.logo')
@elseif($row->role == 4)
@include('front.footer.deskripsi')
@elseif($row->role == 5)
@include('front.footer.semua_kategori')
@elseif($row->role == 6)
@include('front.footer.profile_website')
@elseif($row->role == 7)
@include('front.footer.special_offer')
@elseif($row->role == 8)
@include('front.footer.menu')
@elseif($row->role == 9)
@include('front.footer.gallery')
@elseif($row->role == 10)
@include('front.footer.list_category')
@elseif($row->role == 11)
@include('front.footer.map')
@endif                
@endforeach
      </div>
    
      <div class="w3-third w3-padding-small" >
@foreach($main['footer_kolom2'] as $row)
@if($row->role == 1)
@include('front.footer.sosial_media')
@elseif($row->role == 2)
@include('front.footer.kontak')
@elseif($row->role == 3)
@include('front.footer.logo')
@elseif($row->role == 4)
@include('front.footer.deskripsi')
@elseif($row->role == 5)
@include('front.footer.semua_kategori')
@elseif($row->role == 6)
@include('front.footer.profile_website')
@elseif($row->role == 7)
@include('front.footer.special_offer')
@elseif($row->role == 8)
@include('front.footer.menu')
@elseif($row->role == 9)
@include('front.footer.gallery')
@elseif($row->role == 10)
@include('front.footer.list_category')
@elseif($row->role == 11)
@include('front.footer.map')
@endif                
@endforeach
      </div>

      <div class="w3-third w3-padding-small w3-left" style="padding-left: 50px !important">
@foreach($main['footer_kolom3'] as $row)
@if($row->role == 1)
@include('front.footer.sosial_media')
@elseif($row->role == 2)
@include('front.footer.kontak')
@elseif($row->role == 3)
@include('front.footer.logo')
@elseif($row->role == 4)
@include('front.footer.deskripsi')
@elseif($row->role == 5)
@include('front.footer.semua_kategori')
@elseif($row->role == 6)
@include('front.footer.profile_website')
@elseif($row->role == 7)
@include('front.footer.special_offer')
@elseif($row->role == 8)
@include('front.footer.menu')
@elseif($row->role == 9)
@include('front.footer.gallery')
@elseif($row->role == 10)
@include('front.footer.list_category')
@elseif($row->role == 11)
@include('front.footer.map')
@endif                
@endforeach
      </div>  

    </div>
  </footer>
  <div class="w3-light-grey w3-center w3-padding-small" style="z-index: 99;position: relative;">Powered by <a href="https://www.tayatha.com/" title="tayatha" target="_blank" class="w3-hover-opacity w3-text-white">tayatha</a></div>  

</body>
</html>
