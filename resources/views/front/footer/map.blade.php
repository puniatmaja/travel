@if($row->judul != '')
		<h3>{{$row->judul}}</h3>
@endif
		<div style="max-height: 300px; overflow: hidden;">
			
		<?= $main['profile_website']->map; ?>		
		</div>
		<br>
		<hr>