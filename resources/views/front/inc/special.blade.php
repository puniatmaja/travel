    <section style="background: #F1F5F8" >
      <div class="w3-row-padding " style="max-width:1100px;margin-top: 76px;margin:0 auto;padding-bottom: 40px">                            
        <div class="w3-light-grey w3-card-4 w3-row-padding-small" style="bottom: 15px;position: relative;">
        <h2 style="text-align: center">{{$row->judul}}</h2>
      </div>
@foreach($Special  as $spesial)
          <div class="w3-col l4 m6 w3-margin-bottom">
            <div class="w3-display-container">        
@if($spesial->page_judul == null)
              <div class="w3-card-2">
                <a href="{{url('link').'/'.$spesial->product_slug}}" title="{{$spesial->product_judul}}">
                  <img src="{{asset('gambar/thumb').'/'.$spesial->product_gambar}}" alt="{{$spesial->product_judul}}" style="width:100%">
                </a>
                <a href="{{url('link').'/'.$spesial->product_slug}}" title="{{$spesial->product_judul}}">
                  <div class="w3-display-bottommiddle w3-dark-grey w3-block w3-padding-small"><h5>{{$spesial->product_judul}}</h5></div>
                </a>
              </div>
@else
              <div class="w3-card-2">
                <a href="{{url().'/'.$spesial->page_slug}}" title="{{$spesial->page_judul}}">
                  <img src="{{asset('gambar/thumb').'/'.$spesial->page_gambar}}" alt="{{$spesial->page_judul}}" style="width:100%">
                </a>
                <a href="{{url().'/'.$spesial->page_slug}}" title="{{$spesial->page_judul}}">
                  <div class="w3-display-bottommiddle w3-dark-grey w3-block w3-padding-small"><h5>{{$spesial->page_judul}}</h5></div>
                </a>
              </div>
@endif
            </div>
          </div>
@endforeach

      </div>          
    </section>