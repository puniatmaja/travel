<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\booking;
use App\administrator;
use DB;
use Mail;
use Session;


class FrontController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {               
        $data['main'] = $this->main(); 
        $data['home'] = DB::table('home_setting')->orderBy('posisi','ASC')->where('status','=',1)->get();
        foreach ($data['home'] as $row) {
            if ($row->status == 1) {
                if ($row->name == 'Slider') {
                    $data[$row->name] = DB::table('slider')->orderBy('id','DESC')->get();
                }elseif($row->name == 'Profile') {
                    $data[$row->name] = true;
                }elseif($row->name == 'Special'){
                    $data[$row->name] = DB::table('special_offer')                                        
                                        ->leftjoin('product','product.id','=','special_offer.id_product')
                                        ->leftjoin('page','page.id','=','special_offer.id_page')
                                        ->orderBy('special_offer.id','DESC')                                        
                                        ->select('product.judul as product_judul','product.slug as product_slug','product.gambar as product_gambar',
                                            'page.judul as page_judul','page.slug as page_slug','page.gambar as page_gambar'
                                                )
                                        ->get();
                }elseif ($row->name == 'Product') {
                    $data[$row->name] = DB::table('kategori')
                                        ->select('judul','gambar','slug')
                                        ->where('status','=',1)
                                        ->get();
                }
            }else{
                $data[$row->name] == '';
            }            
        } 
        // return $data;                    
        return view('front.home')->with($data);
    }
    public function main()
    {
        $data['profile_website'] = DB::table('profile_website')->first();
        $data['menu'] = DB::table('menu')->orderBy('posisi','ASC')->get();
        $data['social_media'] = DB::table('social_media')->orderBy('id','ASC')->get();
        $data['contact'] = DB::table('kontak')->orderBy('id','ASC')->get();
        $data['menu_footer'] = DB::table('menu_footer')->orderBy('id','ASC')->get();        
        $data['footer_kolom1'] = DB::table('footer')->where('posisi','=',1)->get();
        $data['footer_kolom2'] = DB::table('footer')->where('posisi','=',2)->get();
        $data['footer_kolom3'] = DB::table('footer')->where('posisi','=',3)->get();
        $data['kategori'] = DB::table('kategori')->get();
        $data['spesial'] = DB::table('special_offer')                                        
                                    ->leftjoin('product','product.id','=','special_offer.id_product')
                                    ->leftjoin('page','page.id','=','special_offer.id_page')
                                    ->orderBy('product.id','DESC')                                        
                                    ->select('product.judul as product_judul','product.slug as product_slug',
                                        'page.judul as page_judul','page.slug as page_slug')
                                    ->get();
        //footer slider
        $footer_slider = DB::table('footer')->where('role','=',9)->get();
        foreach ($footer_slider as $row) {
            $data['footer_slider'][$row->id_galeri_kategori] = DB::table('galeri')->where('id_galeri_kategori','=',$row->id_galeri_kategori)->take(5)->get();
        }
        //list category
        $list_category = DB::table('footer')->where('role','=',10)->get();
        foreach ($list_category as $row) {
            $data['list_category'][$row->id_galeri_kategori] = DB::table('product')->where('id_kategori','=',$row->id_galeri_kategori)->get();
        }
        //menu navigasi
        foreach ($data['menu'] as $row) {
            $data['parent'][$row->id_parent]=DB::table('product')->where('id_kategori','=',$row->id_parent)->where('status','=',1)->get();
        }
        return $data;
    }
    public function sidebar()
    {
        $data['blog'] = DB::table('blog')->orderBy('id','DESC')->select('judul','slug','gambar')->where('status','=',1)->take(5)->get();
        $category = DB::table('kategori')->select('id','judul','slug')->orderBy('judul','ASC')->get();
        foreach ($category as $row) {            
            $data['product'][$row->slug]['name'] = $row->judul;
            $data['product'][$row->slug]['data'] = DB::table('product')->select('judul','slug','gambar')->where('id_kategori','=',$row->id)->where('status','=',1)->get();
        }
        return $data;   
    }
    public function single_product($param='')
    {
        if ($param == '') {
            return redirect('/');
        }else{
            $data['main'] = $this->main(); 
            $data['sidebar'] = $this->sidebar(); 
            $data['single'] = DB::table('product')
                            ->join('kategori','product.id_kategori','=','kategori.id')
                            ->select('kategori.id as id_cat','product.id','product.judul','product.gambar','product.deskripsi','kategori.judul as judul_cat','product.seo_judul','product.seo_kata_kunci','product.seo_deskripsi','product.slug','kategori.slug as slug_cat')
                            ->where('product.slug','=',$param)
                            ->where('product.status','=',1)
                            ->first();            
            if (!empty($data['single'])) {
            $data['tag'] = DB::table('all_tag')                                                
                            ->join('tag','all_tag.id_tag','=','tag.id')            
                            ->select('tag.judul','tag.slug')
                            ->where('all_tag.id_product','=',$data['single']->id)
                            ->get();
            $data['slider'] = DB::table('galeri')
                            ->where('id_product','=',$data['single']->id)
                            ->select('judul','gambar')
                            ->get();
            $data['related']= DB::table('product')->select('judul','gambar','slug')->where('id_kategori','=',$data['single']->id_cat)->where('id','!=',$data['single']->id)->where('status','=',1)->take(3)->orderBy('id','DESC')->get();
            }
            return view('front.single_product')->with($data);
        }
    }
    public function single_blog($param='')
    {
        if ($param == '') {
            return redirect('/');
        }else{
            $data['main'] = $this->main(); 
            $data['sidebar'] = $this->sidebar();
            
            $data['single'] = DB::table('blog')
                            ->join('blog_kategori','blog.id_blog_kategori','=','blog_kategori.id')
                            ->select('blog_kategori.id as id_cat','blog.id','blog.judul','blog.gambar','blog.deskripsi','blog_kategori.judul as judul_cat','blog.seo_judul','blog.seo_kata_kunci','blog.seo_deskripsi','blog.slug','blog_kategori.slug as slug_cat')
                            ->where('blog.slug','=',$param)
                            ->where('blog.status','=',1)
                            ->first();
            if (!empty($data['single'])) {
              
            $data['tag'] = DB::table('all_tag')                                                
                            ->join('tag','all_tag.id_tag','=','tag.id')            
                            ->select('tag.judul','tag.slug')
                            ->where('all_tag.id_blog','=',$data['single']->id)
                            ->get();            
            $data['related']= DB::table('blog')->select('judul','gambar','slug')->where('id_blog_kategori','=',$data['single']->id_cat)->where('id','!=',$data['single']->id)->where('status','=',1)->take(3)->orderBy('id','DESC')->get();
            }  
            return view('front.single_blog')->with($data);
        }
    }   
    public function single_page($param='')
    {
        if ($param == '') {
            return redirect('/');
        }else{
            $data['main'] = $this->main(); 
            $data['sidebar'] = $this->sidebar(); 
            $data['single'] = DB::table('page')
                            ->select('page.id','page.judul','page.gambar','page.deskripsi','page.seo_judul','page.seo_kata_kunci','page.seo_deskripsi','page.slug')
                            ->where('page.slug','=',$param)
                            ->where('page.status','=',1)
                            ->first();                                   
            return view('front.single_page')->with($data);
        }
    }
    public function list_product($param='')
    {
        $data['main'] = $this->main(); 
        $data['sidebar'] = $this->sidebar(); 
        if ($param == '') {
            $data['seo'] = DB::table('profile_website')->first();        
            $data['list'] = DB::table('product')
                    ->join('kategori','product.id_kategori','=','kategori.id')
                    ->where('product.status','=',1)
                    ->select('product.judul','product.gambar','product.slug')
                    ->orderBy('product.id','DESC')
                    ->paginate(14);
        }else{
            $data['seo'] = DB::table('kategori')->select('judul','seo_judul','seo_kata_kunci','seo_deskripsi','gambar')->where('slug','=',$param)->first();
            $data['list'] = DB::table('product')
                        ->join('kategori','product.id_kategori','=','kategori.id')
                        ->where('kategori.slug','=',$param)
                        ->where('product.status','=',1)
                        ->select('product.judul','product.gambar','product.slug')
                        ->orderBy('product.id','DESC')
                        ->paginate(14);            
        }        
        // return $data['list'];
        return view('front.list_product')->with($data);

    }
    public function list_blog($param='')
    {
        $data['main'] = $this->main(); 
        $data['sidebar'] = $this->sidebar(); 
        if ($param == '') {
            $data['seo'] = DB::table('profile_website')->first();
            $data['list'] = DB::table('blog')
                    ->join('blog_kategori','blog.id_blog_kategori','=','blog_kategori.id')
                    ->where('blog.status','=',1)
                    ->select('blog.judul','blog.gambar','blog.slug')
                    ->orderBy('blog.id','DESC')
                    ->paginate(14);
        }else{
            $data['seo'] = DB::table('blog_kategori')->select('judul','seo_judul','seo_kata_kunci','seo_deskripsi')->where('slug','=',$param)->first();
            $data['list'] = DB::table('blog')
                        ->join('blog_kategori','blog.id_blog_kategori','=','blog_kategori.id')
                        ->where('blog_kategori.slug','=',$param)
                        ->where('blog.status','=',1)
                        ->select('blog.judul','blog.gambar','blog.slug')
                        ->orderBy('blog.id','DESC')
                        ->paginate(14);            
        }
        return view('front.list_blog')->with($data);
    }
    
    public function list_tag($param='')
    {
        
        if ($param == '') {
            return redirect('/');
        }else{
            $data['main'] = $this->main(); 
            $data['sidebar'] = $this->sidebar(); 
            $data['seo'] = DB::table('tag')->where('slug','=',$param)->first();            
            $data['list'] = DB::table('all_tag')
                            ->leftjoin('product','all_tag.id_product','=','product.id')
                            ->leftjoin('blog','all_tag.id_blog','=','blog.id')
                            ->join('tag','tag.id','=','all_tag.id_tag')
                            ->where('tag.slug','=',$param)
                            // ->where('product.status','=',1)
                            // ->where('blog.status','=',1)
                            ->orderBy('all_tag.id','DESC')
                            ->select('product.judul as judul_product','product.gambar as gambar_product','product.slug as slug_product','product.deskripsi as deskripsi_product','blog.judul as judul_blog','blog.gambar as gambar_blog','blog.slug as slug_blog','blog.deskripsi as deskripsi_blog')
                            ->paginate(8);                                                     
            return view('front.list_tag')->with($data);
        }
    }
    public function list_gallery($param='')
    {
        $data['main'] = $this->main(); 
        $data['sidebar'] = $this->sidebar(); 
        if ($param == '') {
            $data['seo'] = DB::table('profile_website')->first();
            $data['list'] = DB::table('galeri')
                    ->join('galeri_kategori','galeri.id_galeri_kategori','=','galeri_kategori.id')
                    ->where('id_product','=',0)
                    ->where('galeri_kategori.status','=',1)
                    ->select('galeri.judul','galeri.gambar','galeri_kategori.slug')
                    ->orderBy('galeri.id','DESC')
                    ->paginate(14);
        }else{
            $data['seo'] = DB::table('galeri_kategori')->select('judul','seo_judul','seo_kata_kunci','seo_deskripsi')->where('slug','=',$param)->first();
            $data['list'] = DB::table('galeri')
                    ->join('galeri_kategori','galeri.id_galeri_kategori','=','galeri_kategori.id')
                    ->where('galeri.id_product','=',0)
                    ->where('galeri_kategori.slug','=',$param)
                    ->select('galeri.judul','galeri.gambar','galeri_kategori.slug')
                    ->orderBy('galeri.id','DESC')
                    ->paginate(14);            
        }
        return view('front.list_gallery')->with($data); 
    }
    public function search(Request $request)
    {           
        $data['main'] = $this->main(); 
        $data['sidebar'] = $this->sidebar();
        $data['list'] = DB::table('product')->where('judul','like','%'.$request->get('search').'%')->paginate(14);                    
        return view('front.search')->with($data); 
    }
    public function contact()
    {
        $data['main'] = $this->main(); 
        $data['sidebar'] = $this->sidebar();

        return view('front.contact')->with($data); 
    }
    public function booking()
    {
        $data['main'] = $this->main(); 
        $data['sidebar'] = $this->sidebar(); 
        $category = DB::table('kategori')->select('id','judul','slug')->orderBy('judul','ASC')->get();
        foreach ($category as $row) {
            $data['product'][$row->slug]['name'] = $row->judul;
            $data['product'][$row->slug]['slug'] = $row->slug;
            $data['product'][$row->slug]['data'] = DB::table('product')->select('judul','slug','gambar')->where('id_kategori','=',$row->id)->where('status','=',1)->get();
        }
        return view('front.booking')->with($data); 
    }
    public function booking_send(Request $request)
    {
        if ($request->input('g-recaptcha-response')) { 
            $data['request'] = $request->all();
            $data['site'] =DB::table('profile_website')->first();
            $data['kontak'] =DB::table('kontak')->get();
            Mail::send('front.email',$data, function($message) use ($data)
            {            
                $message->from($data['request']['email'],$data['request']['name']);
                $message->to($data['site']->email,$data['site']->judul)->subject('Booking Tour');
                $message->cc($data['request']['email'],$data['request']['name']);
            });
            $deskripsi = 'Name :'.$request->input('name').'<br> Address :'.$request->input('address').'<br> Hotel :'.$request->input('hotel').'<br> Phone Number :'.$request->input('phone').'<br> Child :'.$request->input('child').'<br> Adult :'.$request->input('adult').'<br><br> Activities Tour : <br><b>Select Tour : </b><br>'.@implode($request->input('tour'),'<br>').'<br><b>Custom Tour : </b><br>'.@implode($request->input('custom_tour'),'<br>').'<br><br> Message :<br>'.$request->input('message');
            $post = array('nama' => $request->input('name'),
                            'email' => $request->input('email'),
                            'deskripsi' => $deskripsi,
                            'tanggal' => $request->input('date'));
            DB::table('booking')->insert($post);
            return redirect()->back()->with('msg', 'We would like to thank you for choosing . Following to your reservation here we are pleased to confirm your booking as follow ');
        }else{
           return redirect()->back()->with('msg', 'Please checked reCAPTCHA');  
        }
    }
    public function contact_send(Request $request)
    {    
        if ($request->input('g-recaptcha-response')) {
            $data['request'] = $request->all();
            $data['site'] =DB::table('profile_website')->first();
            $data['kontak'] =DB::table('kontak')->get();
            Mail::send('front.email_contact',$data, function($message) use ($data)
            {            
                $message->from($data['request']['email'],$data['request']['name']);
                $message->to($data['site']->email,$data['site']->judul)->subject($data['request']['subject']);
                $message->cc($data['request']['email'],$data['request']['name']);
            });                                
            return redirect()->back()->with('msg', 'Message Has Send');
        }else{
            return redirect()->back()->with('msg', 'Please checked reCAPTCHA'); 
        }
    }
    public function single_send(Request $request)
    {
        if ($request->input('g-recaptcha-response')) {
            $data['request'] = $request->all();
            $data['site'] =DB::table('profile_website')->first();
            $data['kontak'] =DB::table('kontak')->get();
            Mail::send('front.email_single',$data, function($message) use ($data)
            {            
                $message->from($data['request']['email'],$data['request']['name']);
                $message->to($data['site']->email,$data['site']->judul)->subject('Booking Tour');
                $message->cc($data['request']['email'],$data['request']['name']);
            });
            $deskripsi = 'Name :'.$request->input('name').'<br> Address :'.$request->input('address').'<br> Hotel :'.$request->input('hotel').'<br> Phone Number :'.$request->input('phone').'<br> Child :'.$request->input('child').'<br> Adult :'.$request->input('adult').'<br><br> Activities Tour : <b>'.$request->input('tour').'</b><br>'.'<br><br> Message :<br>'.$request->input('message');
            $post = array('nama' => $request->input('name'),
                            'email' => $request->input('email'),
                            'deskripsi' => $deskripsi,
                            'tanggal' => $request->input('date'));
            DB::table('booking')->insert($post);                
            return redirect()->back()->with('msg', 'We would like to thank you for choosing . Following to your reservation here we are pleased to confirm your booking as follow ');
        }else{
            return redirect()->back()->with('msg', 'Please checked reCAPTCHA'); 
        }
    }
    public function home_send(Request $request)
    {
        if ($request->input('g-recaptcha-response')) {
            $data['request'] = $request->all();
            $data['site'] =DB::table('profile_website')->first();
            $data['kontak'] =DB::table('kontak')->get();
            Mail::send('front.email_home',$data, function($message) use ($data)
            {            
                $message->from($data['request']['email'],$data['request']['name']);
                $message->to($data['site']->email,$data['site']->judul)->subject('Booking Tour');
                $message->cc($data['request']['email'],$data['request']['name']);
            });
            $deskripsi = 'Name :'.$request->input('name').'<br> Address :'.$request->input('address').'<br> Hotel :'.$request->input('hotel').'<br> Phone Number :'.$request->input('phone').'<br> Child :'.$request->input('child').'<br> Adult :'.$request->input('adult').'<br><br> Activities Tour : <b>'.$request->input('custom_tour').'</b><br>'.'<br><br> Message :<br>'.$request->input('message');
            $post = array('nama' => $request->input('name'),
                            'email' => $request->input('email'),
                            'deskripsi' => $deskripsi,
                            'tanggal' => $request->input('date'));
            DB::table('booking')->insert($post);         
            return redirect()->back()->with('msg', 'We would like to thank you for choosing . Following to your reservation here we are pleased to confirm your booking as follow '); 
        }else{
            return redirect()->back()->with('msg', 'Please checked reCAPTCHA'); 
        }
        

    }
    public function login($value='')
    {
        if (Session::get('status') == 'login') {
            return redirect('admin');
        }else{
            return view('admin.login');
        }
    }
    public function log_in(Request $request)
    {
       $single = administrator::where('username','=', $request->input('username'))->get();                
        if ($single->count() == 0){
            return response()->json(['error' => 'Password Salah Atau Username Salah']);        
        }else{
           if($single[0]->password == crypt($request->input('password'),$single[0]->password) ) {                
                Session::set('name',$single[0]->name);
                Session::set('status','login'); 
                return response()->json(['success' => 'true',
                                        'name' => $single[0]->name,
                                        'status' => 'login']);                
           }else{
                return response()->json(['error' => 'Password Salah']);    
           }
        }

    }  
}
