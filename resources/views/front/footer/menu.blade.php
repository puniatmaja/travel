@if($row->judul != '')
		<h3>{{$row->judul}}</h3>
@endif
@foreach($main['menu'] as $key)  
@if($key->link == 'kategori')    
@else
		<p><a href="{{$key->link}}" title="{{$key->judul}}">{{$key->judul}}</a></p>	
@endif      
 @endforeach 
		<br>
		<hr>