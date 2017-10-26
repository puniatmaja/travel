<html>
	<head>
		<title>Booking</title>
	</head>
	
	<body style=" color: #000;margin: 0 auto;width: 100%;overflow-x: hidden;font-family: sans-serif;">

	<h1 style="color:#696969;text-align: center;padding-bottom: 25px;border-bottom: 3px solid;border-bottom-color: #27c24c;padding-top: 20px;">{{$site->judul}}</h1>
	
	<h3>Hello {{$request['name']}},</h3>
	<br>
	<br>
	First of all we would like to thank you for choosing . Following to your reservation here we are pleased to confirm your booking as follow details:
	<br>
	<br>

	<table>					
		<tbody>
			<tr>
				<td>Name</td>
				<td>:</td>
				<td>{{$request['name']}}</td>
			</tr>
			<tr>
				<td>Address / Hotel Address</td>
				<td>:</td>
				<td>{{$request['address']}}</td>
			</tr>
			<tr>
				<td>Email</td>
				<td>:</td>
				<td><a href="mailto:{{$request['email']}}">{{$request['email']}}</a></td>
			</tr>
			<tr>
				<td>Hotel</td>
				<td>:</td>
				<td>{{$request['hotel']}}</td>
			</tr>
			<tr>
				<td>Phone / Hotel Number</td>
				<td>:</td>
				<td>{{$request['phone']}}</td>
			</tr>
			<tr>
				<td>Activities Date</td>
				<td>:</td>
				<td>{{$request['date']}}</td>
			</tr>
			<tr>
				<td>Child</td>
				<td>:</td>
				<td>{{$request['child']}}</td>
			</tr>
			<tr>
				<td>Adult</td>
				<td>:</td>
				<td>{{$request['adult']}}</td>
			</tr>
			<tr>
				<td><b>Tour Activities</b></td>
				<td>:</td>
				<td>				
					<b>{{$request['tour']}}</b>
				</td>
			</tr>
			<tr>
				<td>Message</td>
				<td>:</td>
				<td>{{$request['message']}}</td>
			</tr>
		</tbody>
	</table>
	<h4>For further information, please contact us at:</h4>
	<table>		
		
		<tbody>
			<tr>
				<td>Company</td>
				<td>:</td>
				<td>{{$site->judul}}</td>
			</tr>
			<tr>
				<td>Email</td>
				<td>:</td>
				<td><a href="mailto:{{$site->email}}">{{$site->email}}</a></td>
			</tr>
			<tr>
				<td>Address</td>
				<td>:</td>
				<td>{{$site->alamat}}</td>
			</tr>
			@foreach($kontak as $key)
			<tr>
				<td>{{$key->judul}}</td>
				<td>:</td>
				<td>{{$key->kontak}}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	<br>
	<br>
	<br>
	<p>thanks,</p>
	<br>
	<br>
	<div style="color:grey;width: 100%;text-align: center;padding: 10px;background-color: #EDECEC">
		<strong style="color:#696969;">{{$site->judul}}</strong><br>
		<small>{{$site->alamat}}</small><br>
		@foreach($kontak as $key)
			<small>{{$key->judul}}:{{$key->kontak}}</small><br>
		@endforeach
		<small><a href="{{url('')}}" title="{{$site->judul}}">{{url('')}}</a></small><br>
		<small>Powered by <a href="https://www.tayatha.com/" title="tayatha" target="_blank" class="w3-hover-opacity">tayatha</a></small>
	</div>
	</body>
</html>