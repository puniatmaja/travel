    <header id="slidercontainer" class="w3-display-container w3-animate-opacity">
      <div id="css3slider">
        
@foreach($Slider as $slide)
          <div class="slider">        
            <img src="{{asset('galeri').'/'.$slide->gambar}}" alt="{{$slide->judul}}" title="{{$slide->judul}}">
@if(trim($slide->judul) != "")
              <div class="blank">      
                <div class="w3-display-bottomright w3-light-grey  w3-padding-small w3-hide-medium w3-hide-small" ><h2>{{$slide->judul}}</h2></div>                
                <div class="w3-display-bottomright w3-hide-large" ><h2><span class="w3-tag w3-light-grey w3-wide w3-card-2">{{$slide->judul}}</span></h2></div>
              </div>
@endif
          </div>
@endforeach      
@for ($i = count($Slider); $i < 5; $i++)
@foreach($Slider as $slide)
<?php $i++ ?>
              <div class="slider">        
                <img src="{{asset('galeri').'/'.$slide->gambar}}" alt="{{$slide->judul}}" title="{{$slide->judul}}">
@if(trim($slide->judul) != "")
                  <div class="blank">      
                    <div class="w3-display-bottomright w3-light-grey  w3-padding-small w3-hide-medium w3-hide-small" ><h2>{{$slide->judul}}</h2></div>                
                    <div class="w3-display-bottomright w3-hide-large" ><h2><span class="w3-tag w3-light-grey w3-wide w3-card-2">{{$slide->judul}}</span></h2></div>
                  </div>
@endif
              </div>
@endforeach
@endfor

      </div>
    </header>