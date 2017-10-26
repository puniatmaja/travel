<!-- About/Information menu -->
    <div class="w3-col l4">    
      <!-- Posts -->      
@foreach($sidebar['product'] as $key) 
@if($key['data'] != null)
        <div class="w3-white w3-margin">              
          <div class="w3-container w3-light-grey">
            <h4>{{$key['name']}}</h4>
          </div>
          <ul class="w3-ul w3-hoverable w3-white">
            @foreach($key['data'] as $row)
            <li class="w3-padding">
              <a href="{{url('link/'.$row->slug)}}" title="{{$row->judul}}">
                <img src="{{url('gambar/thumb').'/'.$row->gambar}}" alt="{{$row->judul}}" class="w3-left w3-margin-right" style="width:50px">
              </a>
              <a href="{{url('link/'.$row->slug)}}" title="{{$row->judul}}"><h4 class="w3-large">{{$row->judul}}</h4></a> 
              <span class="w3-clear"></span>
            </li>          
@endforeach
          </ul>
        </div>      
@endif
@endforeach

@if(trim($main['profile_website']->tripadvisor) != '')
      <div class="w3-white w3-margin">
        <div class="w3-container w3-padding w3-light-grey">
          <h4>Tripadvisor</h4>
        </div>
        <?= $main['profile_website']->tripadvisor; ?>
      </div>
@endif

      <!-- Posts -->
      <div class="w3-white w3-margin">              
@if(count($sidebar['blog']) != 0)
        <div class="w3-container w3-light-grey">
          <h4>Blog</h4>
        </div>
@endif
        <ul class="w3-ul w3-hoverable w3-white">
@foreach($sidebar['blog'] as $row)
          <li class="w3-padding">
            <a href="{{url('blog/'.$row->slug)}}" title="{{$row->judul}}">
              <img src="{{url('gambar/thumb').'/'.$row->gambar}}" alt="{{$row->judul}}" class="w3-left w3-margin-right" style="width: 50px">
            </a>
            <a href="{{url('blog/'.$row->slug)}}" title="{{$row->judul}}">
              <h4 class="w3-large">{{$row->judul}}</h4>
            </a>
            <span class="w3-clear"></span>
          </li>
@endforeach
        </ul>
      </div>
      
    <!-- END About/Intro Menu -->
    </div>
