<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\administrator;
use App\tag;
use App\all_tag;
use App\profile_website;
use App\sosial_media;
use App\blog_kategori;
use App\blog;
use App\galeri_kategori;
use App\galeri;
use App\kategori;
use App\product;
use App\page;
use App\menu;
use App\kontak;
use App\menu_footer;
use App\footer;
use App\slider;
use DB;
use Session;

class adminController extends Controller
{
    
    public function index()
    {
        
        return view('admin.index');
    }
    public function angular()
    {
        return view('dashboard.index');
    }    
    public function blog_kategori()
    {
        return blog_kategori::all();
    }    
    public function blog_kategori_baru(Request $request)
    {           
        $post = $request->input();                
        $title_slug = strip_tags($post['judul']);        
        $slug = str_replace(' ','-',$title_slug); 
        $tc = DB::table('blog_kategori')->where('judul', $post['judul'])->get();                                    
        if (count($tc) > 0 ) {                 
            $slugs = $slug.'-'.count($tc);            
            $sc = DB::table('blog_kategori')->where('slug', $tc[0]->slug)->count();                
            if ($sc > 0) {
                $finisslug = $slugs.'-'.$sc;
            }else{
                $finisslug = $slug.'-'.count($tc);
            }            
        }else{
          $finisslug = $slug;  
        }                 
        blog_kategori::create(array_merge($request->all(), ['slug' => strtolower($finisslug).'.html']));
    }
    public function blog_baru(Request $request)
    {           
        $post = $request->input();                        
        $title_slug = strip_tags($post['judul']);        
        $slug = str_replace(' ','-',$title_slug); 
        $tc = DB::table('blog')->where('judul', $post['judul'])->get();                                    
        if (count($tc) > 0 ) {                 
            $slugs = $slug.'-'.count($tc);            
            $sc = DB::table('blog')->where('slug', $tc[0]->slug)->count();                
            if ($sc > 0) {
                $finisslug = $slugs.'-'.$sc;
            }else{
                $finisslug = $slug.'-'.count($tc);
            }                    
        }else{
          $finisslug = $slug;
        }            
        $id = blog::create(array_merge($request->all(), ['slug' => strtolower($finisslug).'.html']))->id;        
        // -----------------------------             
        if (empty($post['tag'])) {              
        }else{            
            $t = explode(',', $post['tag']);                
            foreach ($t as $key) {
                $tag_baru = str_replace('-',' ',trim($key));                
                $tag_find = DB::table('tag')->where('judul', $tag_baru)->get();
                if (count($tag_find) == 0) {                                            
                    $slug = str_replace(' ','-',trim($key));                 
                    $get_count = DB::table('tag')->where('judul', $tag_baru)->get();   
                    $tc = count($get_count);    
                    if ($tc > 0 ) {     
                        $slugs = $slug.'-'.$tc;
                        $slug_count = DB::table('tag')->where('judul', $tag_baru)->get();                          
                        $sc = count($slug_count);
                        if ($sc > 0) {
                            $tag_slug = $slugs.'-'.$sc;
                        }else{
                            $tag_slug = $slug.'-'.$tc;
                        }
                    }
                    else{$tag_slug = $slug;}
                    $data_tag = array('judul' => $tag_baru,
                                        'slug' => strtolower($tag_slug).'.html');
                    $tags = tag::create($data_tag);                  
                    $data_tag = array('id_tag' =>$tags->id,
                                        'id_blog' => $id);
                    if ($tag_baru != '') {
                        if (all_tag::where('id_tag','=',$tags->id)->where('id_blog' ,'=', $id)->get()->count() == 0) { 
                            all_tag::create($data_tag);                 
                        }
                    }
                }else{
                    $id_tag = $tag_find[0]->id;
                    $data_tag = array('id_tag' => $id_tag,
                                        'id_blog' => $id);
                    if ($tag_baru != '') {
                        if (all_tag::where('id_tag','=',$id_tag)->where('id_blog' ,'=', $id)->get()->count() == 0) {
                            all_tag::create($data_tag);         
                        }        
                    }
                } 
            }            
        }   
    }
    public function blog_rubah($id='')
    {                               
         return blog::find($id);
    }  
    public function blog_update(Request $request,$id)
    {
        $post = $request->input();
        if (!empty($post['slug'])) {    
            $title_slug = strip_tags($post['slug']);        
        }else{
            $title_slug = strip_tags($post['judul']);
        }     
        $slug = str_replace(' ','-',$title_slug); 
        $tc = DB::table('blog')->where('slug', $slug)->get();                                    
        if (count($tc) > 0 ) {     
            if ($tc[0]->id == $id and $tc[0]->slug == $post['slug']) {                    
                $finisslug = $slug;
            }else{
                $slugs = $slug.'-'.count($tc);            
                $sc = DB::table('blog')->where('slug', $tc[0]->slug)->count();                
                if ($sc > 0) {
                    $finisslug = $slugs.'-'.$sc;
                }else{
                    $finisslug = $slug.'-'.count($tc);
                }
            }                                
        }else{
          $finisslug = $slug;  
        } 
        // ----------
        if ($post['gambar'] == '') {                      
            unset($request['gambar']);
        }

        
        blog::find($id)->update(array_merge($request->all(), ['slug' => strtolower(str_replace('.html','',$finisslug)).'.html']));
        all_tag::where('id_blog', $id)->delete();
        // -----------------------------                
        if (empty($post['tag'])) {              
        }else{
            
                $t = explode(',', $post['tag']);                
                foreach ($t as $key) {
                    $tag_baru = str_replace('-',' ',trim($key));
                    $tag_find = DB::table('tag')->where('judul', $tag_baru)->get();
                    if (count($tag_find) == 0) {                                            
                        $slug = str_replace(' ','-',trim($key));                 
                        $get_count = DB::table('tag')->where('judul', $tag_baru)->get();   
                        $tc = count($get_count);    
                        if ($tc > 0 ) {     
                            $slugs = $slug.'-'.$tc;
                            $slug_count = DB::table('tag')->where('judul', $tag_baru)->get();                          
                            $sc = count($slug_count);
                            if ($sc > 0) {
                                $tag_slug = $slugs.'-'.$sc;
                            }else{
                                $tag_slug = $slug.'-'.$tc;
                            }
                        }
                        else{$tag_slug = $slug;}
                        $data_tag = array('judul' => $tag_baru,
                                            'slug' => strtolower($tag_slug).'.html');
                        $tags = tag::create($data_tag);                  
                        $data_tag = array('id_tag' =>$tags->id,
                                            'id_blog' => $id);
                        if ($tag_baru != '') {
                            if (all_tag::where('id_tag','=',$tags->id)->where('id_blog' ,'=', $id)->get()->count() == 0 ) { 
                                all_tag::create($data_tag);      
                            }
                        }
                    }else{
                        $id_tag = $tag_find[0]->id;
                        $data_tag = array('id_tag' => $id_tag,
                                            'id_blog' => $id);
                        if ($tag_baru != '') {
                            if (all_tag::where('id_tag','=',$id_tag)->where('id_blog' ,'=', $id)->get()->count() == 0) {
                                all_tag::create($data_tag); 
                            }
                        }
                        
                    } 
                }
            
        }

    }
    public function blog_kategori_rubah($id='')
    {                               
         return blog_kategori::find($id);
    }
    public function get_tag_blog($id)
    {
        $data = DB::table('all_tag')            
            ->join('tag', 'tag.id', '=', 'all_tag.id_tag')
            ->select('tag.judul as text')
            ->where('all_tag.id_blog', '=', $id)
            ->lists('text');                        
            return implode(',',$data);
    }
    public function blog_kategori_update(Request $request,$id)
    {
        $post = $request->input();
        if (!empty($post['slug'])) {    
            $title_slug = strip_tags($post['slug']);        
        }else{
            $title_slug = strip_tags($post['judul']);
        }    
        $slug = str_replace(' ','-',$title_slug); 
        $tc = DB::table('blog_kategori')->where('slug', $slug)->get();                                    
        if (count($tc) > 0 ) {     
            if ($tc[0]->id == $id and $tc[0]->slug == $post['slug']) {                    
                $finisslug = $slug;
            }else{
                $slugs = $slug.'-'.count($tc);            
                $sc = DB::table('blog_kategori')->where('slug', $tc[0]->slug)->count();                
                if ($sc > 0) {
                    $finisslug = $slugs.'-'.$sc;
                }else{                    
                    $finisslug = $slug.'-'.count($tc);
                }
            }                                
        }else{
          $finisslug = $slug;  
        } 
        return DB::table('blog_kategori')->where('id', $id)->update(array_merge($request->all(), ['slug' => strtolower(str_replace('.html','',$finisslug)).'.html']));        
    }
    public function get_all_blog()
    {                
        $data = DB::table('blog')        
            ->leftjoin('blog_kategori', 'blog.id_blog_kategori', '=', 'blog_kategori.id')            
            ->orderBy('blog.id', 'desc')
            ->select('blog.id','blog.slug','blog.judul','blog.status','blog.gambar','blog_kategori.judul as kategori')->get();  
        return $data;
    }
    public function hapus_kategori_blog($id)
    {
        blog_kategori::find($id)->delete();
    }
    public function hapus_blog($id)
    {
        blog::find($id)->delete();
    }
    // ------------
    public function kategori()
    {
        return kategori::all();
    }    
    public function kategori_baru(Request $request)
    {           
        $post = $request->input();                
        $title_slug = strip_tags($post['judul']);        
        $slug = str_replace(' ','-',$title_slug); 
        $tc = DB::table('kategori')->where('judul', $post['judul'])->get();                                    
        if (count($tc) > 0 ) {                 
            $slugs = $slug.'-'.count($tc);            
            $sc = DB::table('kategori')->where('slug', $tc[0]->slug)->count();                
            if ($sc > 0) {
                $finisslug = $slugs.'-'.$sc;
            }else{
                $finisslug = $slug.'-'.count($tc);
            }
        }else{
          $finisslug = $slug;  
        }            
        return kategori::create(array_merge($request->all(), ['slug' => strtolower($finisslug).'.html']));
    }
    public function product_baru(Request $request)
    {           
        $post = $request->input();                        
        if (empty($post['id'])) {
            $id = product::create($request->all())->id;
            return $id;
        }else{
            $title_slug = strip_tags($post['judul']);        
            $slug = str_replace(' ','-',$title_slug); 
            $tc = DB::table('product')->where('id','!=',$post['id'])->where('judul', $post['judul'])->get();
            if (count($tc) > 0 ) {     
                $slugs = $slug.'-'.count($tc);            
                $sc = DB::table('product')->where('id','!=',$post['id'])->where('slug', $tc[0]->slug)->count();
                if ($sc > 0) {
                    $finisslug = $slugs.'-'.$sc;
                }else{
                    $finisslug = $slug.'-'.count($tc);
                }
            }else{
              $finisslug = $slug;
            }
            $galeri = galeri::where('id_product','=',$post['id'])->get();
            if (empty($post['gambar']) ) {
                if (count($galeri) != 0) {
                    $request->request->add(['gambar' => $galeri[0]->gambar]);
                }
                product::find($post['id'])->update(array_merge($request->all(), ['slug' => strtolower($finisslug).'.html']));        
            }else{
                $galeri_found = galeri::where('gambar','=',$post['gambar'])->where('id_product','=',$post['id'])->get();
                if (count($galeri_found) == 0) {                    
                    if (count($galeri) != 0) {    
                        $request->request->add(['gambar' => $galeri[0]->gambar]);
                    }
                }
                product::find($post['id'])->update(array_merge($request->all(), ['slug' => strtolower($finisslug).'.html']));        
            }
            // -----------------------------                
            if (empty($post['tag'])) {              
            }else{
                            
                $t = explode(',', $post['tag']);                
                foreach ($t as $key) {
                    $tag_baru = str_replace('-',' ',trim($key));
                    $tag_find = DB::table('tag')->where('judul', $tag_baru)->get();
                    if (count($tag_find) == 0) {                                            
                        $slug = str_replace(' ','-',trim($key));                 
                        $get_count = DB::table('tag')->where('judul', $tag_baru)->get();   
                        $tc = count($get_count);    
                        if ($tc > 0 ) {     
                            $slugs = $slug.'-'.$tc;
                            $slug_count = DB::table('tag')->where('judul', $tag_baru)->get();                          
                            $sc = count($slug_count);
                            if ($sc > 0) {
                                $tag_slug = $slugs.'-'.$sc;
                            }else{
                                $tag_slug = $slug.'-'.$tc;
                            }
                        }
                        else{$tag_slug = $slug;}
                        $data_tag = array('judul' => $tag_baru,
                                            'slug' => strtolower($tag_slug).'.html');
                        $tags = tag::create($data_tag);                  
                        $data_tag = array('id_tag' =>$tags->id,
                                            'id_product' => $post['id']);
                        if ($tag_baru != '') {
                            if (all_tag::where('id_tag','=',$tags->id)->where('id_product' ,'=', $post['id'])->get()->count() == 0) { 
                                all_tag::create($data_tag);       
                            }
                        }
                    }else{
                        $id_tag = $tag_find[0]->id;
                        $data_tag = array('id_tag' => $id_tag,
                                            'id_product' => $post['id']);
                        if ($tag_baru != '') {
                            if (all_tag::where('id_tag','=',$id_tag)->where('id_product' ,'=', $post['id'])->get()->count() == 0) {
                                all_tag::create($data_tag);                 
                            }
                        }
                    } 
                }
            
            }
        }
    }
    public function product_key_up_update(Request $request)
    {
        product::find($request->input('id'))->update($request->all());
    }
    public function product_gambar(Request $request)
    {                                               
            $galeri = array('gambar' => $request->input('text'),                            
                            'id_product' => $request->input('data'));
            galeri::create($galeri);        
    }  
    public function get_product_gambar($id)
    {
        return galeri::where('id_product','=',$id)->get();
    }
    public function hapus_product_gambar($id)
    {
        galeri::find($id)->delete();
    }
    public function product_rubah($id='')
    {                               
         return product::find($id);
    }  
    public function product_update(Request $request,$id)
    {
        $post = $request->input();
        if (!empty($post['slug'])) {    
            $title_slug = strip_tags($post['slug']);        
        }else{
            $title_slug = strip_tags($post['judul']);
        }
        $slug = str_replace(' ','-',$title_slug); 
        $tc = DB::table('product')->where('slug', $slug)->get();                                    
        if (count($tc) > 0 ) {     
            if ($tc[0]->id == $id and $tc[0]->slug == $post['slug']) {                    
                $finisslug = $slug;
            }else{
                $slugs = $slug.'-'.count($tc);            
                $sc = DB::table('product')->where('slug', $tc[0]->slug)->count();                
                if ($sc > 0) {
                    $finisslug = $slugs.'-'.$sc;
                }else{
                    $finisslug = $slug.'-'.count($tc);
                }
            }                                
        }else{
          $finisslug = $slug;  
        } 
        // ----------
        if ($post['gambar'] == '') {                           
            unset($request['gambar']);
        }
        $galeri = galeri::where('id_product','=',$post['id'])->get();
        if (empty($post['gambar']) ) {
            if (count($galeri) != 0) {
                $request->request->add(['gambar' => $galeri[0]->gambar]);
            }
            product::find($post['id'])->update(array_merge($request->all(), ['slug' => strtolower(str_replace('.html','',$finisslug)).'.html']));        
        }else{
            $galeri_found = galeri::where('gambar','=',$post['gambar'])->where('id_product','=',$post['id'])->get();
            if (count($galeri_found) == 0) {
                if (count($galeri) != 0) {    
                    $request->request->add(['gambar' => $galeri[0]->gambar]);
                }
            }
            product::find($post['id'])->update(array_merge($request->all(), ['slug' => strtolower(str_replace('.html','',$finisslug)).'.html']));        
        }
        product::find($id)->update(array_merge($request->all(), ['slug' => strtolower(str_replace('.html','',$finisslug)).'.html']));
        all_tag::where('id_product', $id)->delete();
        // -----------------------------                
        if (empty($post['tag'])) {              
        }else{
             
            $t = explode(',', $post['tag']);                
            foreach ($t as $key){
                $tag_baru = str_replace('-',' ',trim($key));
                $tag_find = DB::table('tag')->where('judul', $tag_baru)->get();
                if (count($tag_find) == 0) {                                            
                    $slug = str_replace(' ','-',trim($key));                 
                    $get_count = DB::table('tag')->where('judul', $tag_baru)->get();   
                    $tc = count($get_count);    
                    if ($tc > 0 ) {     
                        $slugs = $slug.'-'.$tc;
                        $slug_count = DB::table('tag')->where('judul', $tag_baru)->get();                          
                        $sc = count($slug_count);
                        if ($sc > 0) {
                            $tag_slug = $slugs.'-'.$sc;
                        }else{
                            $tag_slug = $slug.'-'.$tc;
                        }
                    }
                    else{$tag_slug = $slug;}
                    $data_tag = array('judul' => $tag_baru,
                                        'slug' => strtolower($tag_slug).'.html');
                    $tags = tag::create($data_tag);              
                    $data_tag = array('id_tag' =>$tags->id,
                                        'id_product' => $id);                        
                    if ($tag_baru != '') {
                        if (all_tag::where('id_tag','=',$tags->id)->where('id_product' ,'=', $id)->get()->count() == 0) { 
                            all_tag::create($data_tag);                 
                        }
                    }
                }else{
                    $id_tag = $tag_find[0]->id;
                    $data_tag = array('id_tag' => $id_tag,
                                        'id_product' => $id);
                    if ($tag_baru != '') {
                        if (all_tag::where('id_tag','=',$id_tag)->where('id_product' ,'=', $id)->get()->count() == 0) {
                            all_tag::create($data_tag); 
                        }
                    }
                }
            } 
            
        }

    }
    public function kategori_rubah($id='')
    {                               
         return kategori::find($id);
    }
    public function get_tag_product($id)
    {
        $data = DB::table('all_tag')            
            ->join('tag', 'tag.id', '=', 'all_tag.id_tag')
            ->select('tag.judul as text')
            ->where('all_tag.id_product', '=', $id)
            ->lists('text');                        
            return implode(',',$data);
    }
    public function kategori_update(Request $request,$id)
    {
        $post = $request->input();
        if (!empty($post['slug'])) {    
            $title_slug = strip_tags($post['slug']);        
        }else{
            $title_slug = strip_tags($post['judul']);
        }      
        $slug = str_replace(' ','-',$title_slug); 
        $tc = DB::table('kategori')->where('slug', $slug)->get();                                    
        if (count($tc) > 0 ) {     
            if ($tc[0]->id == $id and $tc[0]->slug == $post['slug']) {                    
                $finisslug = $slug;
            }else{
                $slugs = $slug.'-'.count($tc);            
                $sc = DB::table('kategori')->where('slug', $tc[0]->slug)->count();                
                if ($sc > 0) {
                    $finisslug = $slugs.'-'.$sc;
                }else{
                    $finisslug = $slug.'-'.count($tc);
                }
            }                                
        }else{
          $finisslug = $slug;  
        } 
        if ($post['gambar'] == '' ) {
            unset($request['gambar']);
        }                               
        kategori::find($id)->update(array_merge($request->all(), ['slug' => strtolower(str_replace('.html','',$finisslug)).'.html']));                
    }
    public function get_all_product()
    {                
        $data = DB::table('product')        
            ->leftjoin('kategori', 'product.id_kategori', '=', 'kategori.id')            
            ->orderBy('product.id', 'desc')
            ->select('product.id','product.slug','product.judul','product.status','product.gambar','kategori.judul as kategori')
            ->get();  

        return $data;
    }
    public function hapus_kategori($id)
    {
        kategori::find($id)->delete();
    }
    public function hapus_product($id)
    {
        product::find($id)->delete();
    }

    // -----------------------page

    public function page_baru(Request $request)
    {           
        $post = $request->input();                        
        $title_slug = strip_tags($post['judul']);        
        $slug = str_replace(' ','-',$title_slug); 
        $tc = DB::table('page')->where('judul', $post['judul'])->get();                                    
        if (count($tc) > 0 ) {                 
            $slugs = $slug.'-'.count($tc);            
            $sc = DB::table('page')->where('slug', $tc[0]->slug)->count();                
            if ($sc > 0) {
                $finisslug = $slugs.'-'.$sc;
            }else{
                $finisslug = $slug.'-'.count($tc);
            }                                    
        }else{
          $finisslug = $slug;
        }                
        page::create(array_merge($request->all(), ['slug' => strtolower($finisslug).'.html']));

    }
    public function page_rubah($id='')
    {                               
         return page::find($id);
    }  
    public function page_update(Request $request,$id)
    {
        $post = $request->input();
        if (!empty($post['slug'])) {    
            $title_slug = strip_tags($post['slug']);        
        }else{
            $title_slug = strip_tags($post['judul']);
        }
        $slug = str_replace(' ','-',$title_slug); 
        $tc = DB::table('page')->where('slug', $slug)->get();                                    
        if (count($tc) > 0 ) {     
            if ($tc[0]->id == $id and $tc[0]->slug == $post['slug']) {                    
                $finisslug = $slug;
            }else{
                $slugs = $slug.'-'.count($tc);            
                $sc = DB::table('page')->where('slug', $tc[0]->slug)->count();                
                if ($sc > 0) {
                    $finisslug = $slugs.'-'.$sc;
                }else{
                    $finisslug = $slug.'-'.count($tc);
                }
            }                                
        }else{
          $finisslug = $slug;  
        } 
        // ----------
        if ($post['gambar'] == '') {                           
            unset($request['gambar']);
        }
        page::find($id)->update(array_merge($request->all(), ['slug' => strtolower(str_replace('.html','',$finisslug)).'.html']));        

    }

    public function get_all_page()
    {
        return page::all();
    }
    public function hapus_page($id)
    {
        page::find($id)->delete();
    }
    // -----------------setting
    // -----------------sosial media
    public function sosial_media()
    {
        return sosial_media::all();
    }
    public function sosial_media_baru(Request $request)
    {   
        $gambar='';
        $post = $request->input();
        if ($post['ikon'] == 'upload') {
            $gambar = $post['gambar'];
        }else{
            $gambar = $post['ikon'];
        }
        $data = array('judul' => $post['judul'],
                        'link' => $post['link'],
                        'gambar' => $gambar);        
        sosial_media::create($data);     
    }
    public function sosial_media_rubah($id='')
    {                               
         return sosial_media::find($id);
    }  
    public function sosial_media_update(Request $request,$id)
    {
        $post = $request->input();                    
        sosial_media::find($id)->update($request->all());
    }
    public function sosial_media_ikon(Request $request,$id)
    {
        $gambar = '';
        $post = $request->input();
        if ($post['ikon'] == 'upload') {
            $gambar = $post['gambar'];
        }else{
            $gambar = $post['ikon'];        
        }
        $data = array('gambar' => $gambar);                
        sosial_media::find($id)->update($data);
    }
    public function hapus_sosial_media($id)
    {
        sosial_media::find($id)->delete();
    }
    // -----------------Kontak
    public function kontak()
    {
        return kontak::all();
    }
    public function kontak_baru(Request $request)
    {                           
        $post = $request->input();
        if (empty($post['gambar'])) {
            $request->request->add(['role' => 0]);
        }elseif ($post['gambar'] == 'sm/email.png') {
            $request->request->add(['role' => 1]);            
        }elseif($post['gambar'] == 'sm/phone.png'){
            $request->request->add(['role' => 2]);
        }elseif($post['gambar'] == 'sm/wa.png'){
            $request->request->add(['role' => 3]);
        }elseif($post['gambar'] == 'sm/wechat.png'){
            $request->request->add(['role' => 4]);
        }elseif($post['gambar'] == 'sm/kakaotalk.png'){
            $request->request->add(['role' => 5]);
        }elseif($post['gambar'] == 'sm/viber.png'){
            $request->request->add(['role' => 6]);
        }elseif($post['gambar'] == 'sm/line.png'){
            $request->request->add(['role' => 0]);
        }else{
            $request->request->add(['role' => 0]);
        }
         kontak::create($request->all());    
    }
    public function kontak_rubah($id='')
    {                               
         return kontak::find($id);
    }  
    public function kontak_update(Request $request,$id)
    {        
        $post = $request->input();        
        if (empty($post['gambar'])) {            
            $request->request->add(['role' => 0]); 
        }elseif ($post['gambar'] == 'sm/email.png') {
            $request->request->add(['role' => 1]);            
        }elseif($post['gambar'] == 'sm/phone.png'){
            $request->request->add(['role' => 2]);
        }elseif($post['gambar'] == 'sm/wa.png'){
            $request->request->add(['role' => 3]);
        }elseif($post['gambar'] == 'sm/wechat.png'){
            $request->request->add(['role' => 4]);
        }elseif($post['gambar'] == 'sm/kakaotalk.png'){
            $request->request->add(['role' => 5]);
        }elseif($post['gambar'] == 'sm/viber.png'){
            $request->request->add(['role' => 6]);
        }elseif($post['gambar'] == 'sm/line.png'){
            $request->request->add(['role' => 0]);
        }else{
            $request->request->add(['role' => 0]);
        }
        kontak::find($id)->update($request->all());        
    }    
    public function hapus_kontak($id)
    {
        kontak::find($id)->delete();
    }

    // ------------------ profile website
    public function profile_website()
    {
        $count = profile_website::all()->count();        
        if ($count == 0) {
            DB::table('profile_website')->insert(array('judul' => '' ));
        }
        return profile_website::all()->first();
    }
    public function profile_website_update(Request $request)
    {
        $post = $request->input();        
        return DB::table('profile_website')->where('id', $post['id'])->update($request->all());
        // return response()->json(['success' => 'true']);
    }
    public function profile_website_logo(Request $request)
    {        
        $post = $request->input();
        $data = array('logo' => $post['gambar']);
        DB::table('profile_website')->where('id', $post['id'])->update($data);        
    }
    public function profile_website_gambar(Request $request)
    {        
        $post = $request->input();
        $data = array('gambar' => $post['gambar']);
        DB::table('profile_website')->where('id', $post['id'])->update($data);        
    }
    


    // --------- administrator
    public function administrator()
    {               
        $data = administrator::all()->sortByDesc('id');            
        return $data;
    }
    public function administrator_edit($id='')
    {        
        $data = administrator::find($id);
        return $data;                
    }
    public function administrator_update(Request $request,$id)
    {                                       
        if ($request->input('newpassword') == '') {
            $data = array(  'name' => $request->input('name'),
                        'username' => $request->input('username'));
            administrator::find($id)->update($data);
            return response()->json(['success' => true]);
        }
        else {
            $data = array(  'name' => $request->input('name'),
                        'username' => $request->input('username'),
                        'password' => bcrypt($request->input('newpassword')));
            administrator::find($id)->update($data);
            return response()->json(['success' => true]);                 
        }
    }
    public function add_administrator(Request $request)
    {                 
        
        $data = array('name' => $request->input('name'),
                    'username' => $request->input('username'),
                    'password' => bcrypt($request->input('password')));          
        administrator::create($data);        
    }
    public function delete_administrator($id)
    {        
        administrator::find($id)->delete();                
    }
    //home setting
    public function home_setting()
    {
        $hs = DB::table('home_setting')->count();
        if ($hs == 0) {
            $data = [
                ['name' => 'Slider','status'=> 0,'judul' => 'Slider','posisi'=>1],
                ['name' => 'Profile','status'=> 0,'judul' => 'Profile','posisi'=>2],
                ['name' => 'Product','status'=> 0,'judul' => 'Product','posisi'=>3],
                ['name' => 'Special','status'=> 0,'judul' => 'Special','posisi'=>4]
            ];
            DB::table('home_setting')->insert($data);            
        }
        return DB::table('home_setting')->orderBy('posisi','ASC')->get();
    }
    public function home_setting_update(Request $request,$id)
    {
        unset($request['accordion']);
        return DB::table('home_setting')->where('id','=',$id)->update($request->all());   
    }
    public function setting_up($id)
    {
        $posisiup = DB::table('home_setting')->find($id);   
        $posisidown = DB::table('home_setting')->where('posisi',$posisiup->posisi-1)->first();
        DB::table('home_setting')->where('id','=',$posisidown->id)->update(array('posisi' => $posisidown->posisi+1 ));
        DB::table('home_setting')->where('id','=',$posisiup->id)->update(array('posisi' => $posisiup->posisi-1 ));
    }
    public function setting_down($id)
    {
        $posisidown = DB::table('home_setting')->find($id);
        $posisiup = DB::table('home_setting')->where('posisi',$posisidown->posisi+1)->first();
        DB::table('home_setting')->where('id','=',$posisiup->id)->update(array('posisi' => $posisiup->posisi-1 ));
        DB::table('home_setting')->where('id','=',$posisidown->id)->update(array('posisi' => $posisidown->posisi+1 ));
    }
    public function get_special()
    {
        $data = DB::table('special_offer')
                ->leftjoin('product','product.id','=','special_offer.id_product')
                ->leftjoin('page','page.id','=','special_offer.id_page')
                ->select('product.judul as product_jud','special_offer.id','page.judul as page_jud')
                ->get();
        return $data;
    }
    public function get_special_kategori($value='')
    {
        $category = DB::table('kategori')->select('id','judul','slug')->orderBy('judul','ASC')->get();
        foreach ($category as $row) {            
            $data['product'][$row->slug]['name'] = $row->judul;
            $data['product'][$row->slug]['id'] = $row->id;            
            $data['product'][$row->slug]['data'] = DB::table('product')->select('id','judul','slug','gambar')->where('id_kategori','=',$row->id)->where('status','=',1)->get();
        }
        return $data;
    }
    public function special_hapus($id)
    {       
        DB::table('special_offer')->where('id',$id)->delete();    
    }           
    public function kategori_setting(Request $request,$id)
    {
        $post = $request->input();
        $data = array('status' => $post['text'] );
        kategori::find($id)->update($data);
    }
    public function setting_active(Request $request,$id)
    {
        $post = $request->input();
        $data = array('status' => $post['text'] );
        DB::table('home_setting')->where('id','=',$id)->update($data);
    }    
    public function select_product(Request $request)
    {                 
        $post = $request->input();
        return product::where('id_kategori', $post['search'])->get();
    }
    public function spesial_produk_page(Request $request)
    {               
        $status = true;
        $warning = false;
        $post = $request->input();                            
        $ceck = DB::table('special_offer')->where('id_page','=',$post['text'])->count();
        if ($ceck == 0) {                    
            $data = array('id_page' => $post['text']);
            DB::table('special_offer')->insert($data);
        }else{
            $status = false;
            $warning = true;

        }
        
        return response()->json(['success' => $status,'warning' => $warning]);
    }
    public function spesial_produk(Request $request)
    {                              
        $status = true;
        $warning = false;
        $post = $request->input();
        foreach ($post['text'] as $key) {                      

            $ceck = DB::table('special_offer')->where('id_product','=',$key)->count();
            if ($ceck == 0) {                    
                $data = array('id_product' => $key);
                DB::table('special_offer')->insert($data);
            }else{
                $status = false;
                $warning = true;

            }
        } 
        return response()->json(['success' => $status,'warning' => $warning]);
    }
    //tag
    public function tag()
    {
        return tag::all();
    } 
    public function tag_rubah($id='')
    {                               
         return tag::find($id);
    }
    public function tag_update(Request $request,$id)
    {
        $post = $request->input();
        if (!empty($post['slug'])) {    
            $title_slug = strip_tags($post['slug']);        
        }else{
            $title_slug = strip_tags($post['judul']);
        }       
        $slug = str_replace(' ','-',$title_slug); 
        $tc = DB::table('tag')->where('slug', $slug)->get();                                    
        if (count($tc) > 0 ) {     
            if ($tc[0]->id == $id and $tc[0]->slug == $post['slug']) {                    
                $finisslug = $slug;
            }else{
                $slugs = $slug.'-'.count($tc);            
                $sc = DB::table('tag')->where('slug', $tc[0]->slug)->count();                
                if ($sc > 0) {
                    $finisslug = $slugs.'-'.$sc;
                }else{
                    $finisslug = $slug.'-'.count($tc);
                }
            }                                
        }else{
          $finisslug = $slug;  
        } 
        
        return DB::table('tag')->where('id', $id)->update(array_merge($request->all(), ['slug' => strtolower(str_replace('.html','',$finisslug)).'.html']));        
    }
    public function hapus_tag($id)
    {
        tag::find($id)->delete();
        DB::table('all_tag')->where('id_tag',$id)->delete();
    }

    //galeri
    public function galeri_kategori()
    {
        return galeri_kategori::all();
    } 
    public function galeri_kategori_baru(Request $request)
    {           
        $post = $request->input();                
        $title_slug = strip_tags($post['judul']);        
        $slug = str_replace(' ','-',$title_slug); 
        $tc = DB::table('galeri_kategori')->where('judul', $post['judul'])->get();                                    
        if (count($tc) > 0 ) {                 
            $slugs = $slug.'-'.count($tc);            
            $sc = DB::table('galeri_kategori')->where('slug', $tc[0]->slug)->count();                
            if ($sc > 0) {
                $finisslug = $slugs.'-'.$sc;
            }else{
                $finisslug = $slug.'-'.count($tc);
            }            
        }else{
          $finisslug = $slug;  
        }             
        return galeri_kategori::create(array_merge($request->all(), ['slug' => strtolower($finisslug).'.html']));


    }
    public function galeri_kategori_rubah($id='')
    {                               
         return galeri_kategori::find($id);
    }
    public function galeri_kategori_update(Request $request,$id)
    {
        $post = $request->input();
        if (!empty($post['slug'])) {    
            $title_slug = strip_tags($post['slug']);        
        }else{
            $title_slug = strip_tags($post['judul']);
        }      
        $slug = str_replace(' ','-',$title_slug); 
        $tc = DB::table('galeri_kategori')->where('slug', $slug)->get();                                    
        if (count($tc) > 0 ) {     
            if ($tc[0]->id == $id and $tc[0]->slug == $post['slug']) {                    
                $finisslug = $slug;
            }else{
                $slugs = $slug.'-'.count($tc);            
                $sc = DB::table('galeri_kategori')->where('slug', $tc[0]->slug)->count();                
                if ($sc > 0) {
                    $finisslug = $slugs.'-'.$sc;
                }else{
                    $finisslug = $slug.'-'.count($tc);
                }
            }                                
        }else{
          $finisslug = $slug;  
        }
        if ($post['gambar'] == '' ) {
            unset($request['gambar']);
        }        
        galeri_kategori::find($id)->update(array_merge($request->all(), ['slug' => strtolower(str_replace('.html','',$finisslug)).'.html']));

    }   

    public function hapus_kategori_galeri($id)
    {        
        galeri_kategori::find($id)->delete();
    }
    public function galeri_baru(Request $request)
    {          
        $post = $request->input();                        
        $data = array(  'gambar' => $post['text'],                        
                        'id_galeri_kategori' => $post['kategori']);        
        return galeri::create($data);
    }
    public function galeri()
    {     
        $data = DB::table('galeri')        
            ->join('galeri_kategori', 'galeri.id_galeri_kategori', '=', 'galeri_kategori.id')            
            ->orderBy('galeri.id', 'desc')    
            ->where('id_product','=',0)        
            ->select('galeri.id','galeri.judul','galeri.gambar','galeri_kategori.judul as kategori')->get();  
        return $data;
    } 
    public function galeri_hapus($id)
    {
        galeri::find($id)->delete();
    }
    public function galeri_rubah($id)
    {                               
         return galeri::find($id);
    }
    public function galeri_update(Request $request,$id)
    {
        $post = $request->input();       
        $data = array(  'judul' => $post['judul'],                        
                        'id_galeri_kategori' => $post['id_galeri_kategori']);
        return DB::table('galeri')->where('id', $id)->update($data);        
    }
    
    //slider
    public function slider_baru(Request $request)
    {          
        $post = $request->input();                        
        $data = array(  'gambar' => $post['text']);        
        return slider::create($data);
    }
    public function slider()
    {              
        return slider::all();
    } 
    public function slider_hapus($id)
    {
        slider::find($id)->delete();
    }
    public function slider_rubah($id)
    {                               
         return slider::find($id);
    }
    public function slider_update(Request $request,$id)
    {
        $post = $request->input();       
        $data = array(  'judul' => $post['judul']);
        return DB::table('slider')->where('id', $id)->update($data);        
    }
    //menu
    public function menu_baru(Request $request)
    {      
        $judul = '';
        $link =   '';
        $post = $request->input();                                
        $count = DB::table('menu')->count();
        if ($post['judul'] =='page') {
            $page = page::find($post['link']);
            $judul = $page['judul'];
            $link = url().'/'.$page['slug'];
            $data = array(  'judul' => $judul,  
                        'link' => $link,
                        'posisi' => $count+1);
        }elseif($post['judul'] =='kategori'){           
            $page = kategori::find($post['link']);
            $judul = $page['judul'];
            $link = $page['slug'];           
            $data = array(  'judul' => $judul,
                        'link' => 'kategori',
                        'id_parent' => $post['link'],
                        'posisi' => $count+1);             
        }elseif($post['judul'] =='blog'){            
            $judul = 'Blog';
            $link =  $post['link'];
            $data = array(  'judul' => $judul,  
                        'link' => $link,
                        'posisi' => $count+1);
        }elseif($post['judul'] =='contact'){
            $judul = 'Contact';
            $link =  $post['link'];
            $data = array(  'judul' => $judul,  
                        'link' => $link,
                        'posisi' => $count+1);
        }elseif($post['judul'] =='booking'){
            $judul = 'Booking';
            $link =  $post['link'];
            $data = array(  'judul' => $judul,  
                        'link' => $link,
                        'posisi' => $count+1);
        }elseif($post['judul'] =='home'){
            $judul = 'Home';
            $link =  $post['link'];
            $data = array(  'judul' => $judul,  
                        'link' => $link,
                        'posisi' => $count+1);
        }else{
            $judul = $post['judul'];
            $link =  $post['link'];
            $data = array(  'judul' => $judul,  
                        'link' => $link,
                        'posisi' => $count+1);
        }              
        menu::create($data);        
    }
    public function get_menu()
    {
        return DB::table('menu')->select('id','judul','posisi','link')->orderBy('posisi', 'asc')->get();        
    }
    public function menu_update(Request $request,$id)
    {
        unset($request['accordion']);
        return DB::table('menu')->where('id','=',$id)->update($request->all());
    }
    public function menu_hapus($id)
    {
        $parent = menu::find($id);
        $posisi = DB::table('menu')->where('posisi','>',$parent['posisi'])->get();
        foreach ($posisi as $row) {          
            menu::find($row->id)->update(array('posisi' => $row->posisi-1 ));
        }        
        menu::find($id)->delete();
    }    
    public function menu_up($id)
    {
        $posisiup = menu::find($id);   
        $posisidown = DB::table('menu')->where('posisi',$posisiup->posisi-1)->first();
        menu::find($posisidown->id)->update(array('posisi' => $posisidown->posisi+1 ));
        menu::find($posisiup->id)->update(array('posisi' => $posisiup->posisi-1 ));
    }
    public function menu_down($id)
    {
        $posisidown = menu::find($id);   
        $posisiup = DB::table('menu')->where('posisi',$posisidown->posisi+1)->first();        
        menu::find($posisiup->id)->update(array('posisi' => $posisiup->posisi-1 ));
        menu::find($posisidown->id)->update(array('posisi' => $posisidown->posisi+1 ));
    }

    // booking
    public function booking_list()
    {
        return DB::table('booking')->where('hapus','=',0)->orderBy('id','DESC')->get();
    } 
    public function booking_single($id)
    {   
        $data['single'] = DB::table('booking')->where('id','=',$id)->first();
        return $data;
    } 
    public function booking_hapus($id)
    {   
        $data = array('hapus' => 1 );
        DB::table('booking')->where('id','=',$id)->update($data);
    }
    //footer
    public function get_footer($posisi)
    {
        if ($posisi == 1) {
            return DB::table('footer')->where('posisi','=',$posisi)->orderBy('id','ASC')->get();
        }elseif ($posisi == 2) {
            return DB::table('footer')->where('posisi','=',$posisi)->orderBy('id','ASC')->get();
        }elseif ($posisi == 3) {
            return DB::table('footer')->where('posisi','=',$posisi)->orderBy('id','ASC')->get();
        }        
    }
    public function add_footer(Request $request)
    {                             
        $judul = '';        
        switch ($request->input('role')) {
            case 1:
                $judul = 'Find Us';
                break;
            case 2:
                $judul = 'Contact';
                break;
            case 3:
                $judul = 'Logo';
                break;
            case 4:
                $judul = 'Deskripsi';
                break;
            case 5:
                $judul = 'Semua Kategori';
                break;
            case 6:
                $judul = 'Profile Website';
                break;
            case 7:
                $judul = 'Special Offer';
                break;
            case 8:
                $judul = 'Menu';
                break;
            case 9:
                $judul = 'Gallery';
                break;
            case 10:
                $categori = kategori::where('id','=',$request->input('id_galeri_kategori'))->select('judul')->first();
                $judul = $categori->judul;
                break;
            case 11:
                $judul = 'Map';
                break;
            default:
                $judul = '';
                break;
        }
        footer::create(array_merge($request->all(), ['judul' => $judul]));        
    }
    public function edit_footer($id)
    {
        return footer::find($id);        
    }
    public function update_footer(Request $request,$id)
    {        
        footer::find($id)->update($request->all());
    }
    public function footer_hapus($id)
    {        
        footer::find($id)->delete();
    }
    //menu footer
    public function menu_footer(Request $request)
    {      
        $judul = '';
        $link =   '';

        $post = $request->input();                                        
        if($post['judul'] =='blog'){            
            $judul = 'Blog';
            $link =  $post['link'];
        }elseif($post['judul'] =='sitemap'){            
            $judul = 'Sitemap';
            $link =  $post['link'];
        }elseif($post['judul'] =='galeri'){            
            $judul = 'Gallery';
            $link =  $post['link'];
        }else{
            $judul = $post['judul'];
            $link =  $post['link'];
        }
        $data = array(  'judul' => $judul,  
                        'link' => $link);
        menu_footer::create($data);        
    }
    public function get_menu_footer()
    {
        return DB::table('menu_footer')->orderBy('id','ASC')->get();        
    }
    public function edit_menu_footer($id)
    {
        return menu_footer::find($id);        
    }
    public function update_menu_footer(Request $request,$id)
    {        
        menu_footer::find($id)->update($request->all());
    }    
    public function menu_footer_hapus($id)
    {        
        menu_footer::find($id)->delete();
    }

    //logout 
    public function logout()
    {                
        session()->flush();
        session()->forget('status');
        session()->forget('name');        
        return response()->json(['success' => 'true']);
    }
}
