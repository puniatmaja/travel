@if($row->judul != '')
		<h3>{{$row->judul}}</h3>
@endif
@foreach($main['kategori'] as $kategori)
		<p><a href="{{url('category').'/'.$kategori->slug}}" title="{{$kategori->judul}}">{{$kategori->judul}}</a></p>
@endforeach
		<br>