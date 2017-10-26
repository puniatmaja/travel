@if($row->judul != '')
		<h3>{{$row->judul}}</h3>
@endif		
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
	  	<a href="{{$link}}" title="{{$contacts->judul}}" target="_blank"><img src="{{asset('gambar').'/'.$contacts->gambar}}" alt="{{$contacts->judul}}" width="30px"></a>
@endif
		{{$contacts->judul}} : <a href="{{$link}}" title="{{$contacts->judul}}" target="_blank">{{$contacts->kontak}}</a></p>
@else

@if($contacts->gambar != '')
	  	<img src="{{asset('gambar').'/'.$contacts->gambar}}" alt="{{$contacts->judul}}" width="30px">
@endif
		{{$contacts->judul}} : {{$contacts->kontak}}</p>
@endif
@endforeach
		<br>
		<hr>