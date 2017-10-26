@if($row->judul != '')
		<h3>{{$row->judul}}</h3>
@endif
		<a href="{{url('/')}}" title="{{$main['profile_website']->judul}}"><img src="{{url('gambar').'/'.$main['profile_website']->logo}}" alt="logo" width="120px"></a>
		<br>
		<hr>