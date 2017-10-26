    <section class="w3-row-padding " style="max-width:1100px;margin-top: 46px;margin:0 auto; padding-bottom: 50px;">
      <div class="w3-light-grey w3-card-2 w3-row-padding-small" style="bottom: 15px;position: relative;">
        <h2 style="text-align: center">{{$row->judul}}</h2>
      </div>

      <div class="w3-row-padding ">    
@foreach($Product as $produk)
          <div class="w3-col l4 m6 w3-margin-bottom">
            <div class="w3-display-container">        
              <div class="w3-card-4">
                <a href="{{url('category').'/'.$produk->slug}}" title="{{$produk->judul}}">
                  <img src="{{asset('gambar/thumb').'/'.$produk->gambar}}" alt="House" style="width:100%">
                </a>
                <a href="{{url('category').'/'.$produk->slug}}" title="{{$produk->judul}}">
                  <div class="w3-display-bottommiddle w3-light-grey w3-block w3-padding-small"><h5> {{$produk->judul}} </h5></div>
                </a>
              </div>
            </div>
          </div>
@endforeach

      </div>
    </section>