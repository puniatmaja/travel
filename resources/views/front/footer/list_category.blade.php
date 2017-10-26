@if($row->judul != '')
		<h3>{{$row->judul}}</h3>
@endif
@foreach($main['list_category'][$row->id_galeri_kategori] as $list_categorys)
		<p><a href="{{url('link').'/'.$list_categorys->slug}}" title="{{$list_categorys->judul}}">{{$list_categorys->judul}}</a></p>	
@endforeach
		<br>