    <section class="w3-row w3-padding-64" id="menu" style="max-width:1100px;margin-top: 46px;margin:0 auto" >
      <div class="w3-col m6 w3-padding-large">    
        <div class="w3-dark-grey w3-card-4">
          <h3 style="text-align: center">{{$row->judul}}</h3>
        </div>
        <div class="w3-col m12">
          <div class="w3-card-2 w3-round w3-white w3-margin-top w3-margin-bottom">
            <div class="w3-container w3-padding-small">
              <small class="w3-text-grey">
                Home
              </small>
            </div>
          </div>
        </div>
        <p class="w3-text-grey"><?= $main['profile_website']->deskripsi ?></p>
        <hr>        
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
          <a href="{{$link}}" title="{{$contacts->judul}}" target="_blank"><img src="{{asset('gambar').'/'.$contacts->gambar}}" alt="{{$contacts->judul}}" width="40px"></a>
@endif
@endforeach
        
      </div>
      
      <div class="w3-col m6 w3-padding-large">
        <img src="{{asset('gambar').'/'.$main['profile_website']->gambar}}" class="w3-round w3-image" alt="{{$main['profile_website']->judul}}" width="500" height="450">
      </div>
    </section>
