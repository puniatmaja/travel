@if($row->judul != '')
		<h3>{{$row->judul}}</h3>
@endif
@foreach($main['spesial'] as $spesial)
@if($spesial->page_judul == null)		
		<p><a href="{{url('link').'/'.$spesial->product_slug}}" title="{{$spesial->product_judul}}">{{$spesial->product_judul}}</a></p>	
@else
		<p><a href="{{url().'/'.$spesial->page_slug}}" title="{{$spesial->page_judul}}">{{$spesial->page_judul}}</a></p>	
@endif
@endforeach
		<br>