@if($row->judul != '')
		<h3>{{$row->judul}}</h3>
@endif
		<div id="slidercontainerf" >
		  	<div id="css3sliderf">
@foreach($main['footer_slider'][$row->id_galeri_kategori] as $key)
	    		<img src="{{asset('galeri').'/'.$key->gambar}}" alt="{{$key->judul}}" title="{{$key->judul}}">
@endforeach
@for ($i = count($main['footer_slider'][$row->id_galeri_kategori]); $i < 5; $i++)
<?php $i++ ?>
@foreach($main['footer_slider'][$row->id_galeri_kategori] as $key)
			    <img src="{{asset('galeri').'/'.$key->gambar}}" alt="{{$key->judul}}" title="{{$key->judul}}">
@endforeach
@endfor    
			</div>
		</div>