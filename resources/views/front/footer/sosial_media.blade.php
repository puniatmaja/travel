@if($row->judul != '')
		<h3>{{$row->judul}}</h3>
@endif
@foreach($main['social_media'] as $social_media)
		<a href="{{$social_media->link}}" title="{{$social_media->judul}}"><img src="{{asset('gambar').'/'.$social_media->gambar}}" alt="{{$social_media->judul}}" width="40px"></a>
@endforeach
		<br>
