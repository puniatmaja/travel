<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\category;
use App\tag;
use App\product;
use App\product_tag;
use DB;
use App\administrator;
use Session;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['category'] = DB::table('categorys')                                
            ->select('name','slug')            
            ->orderBy('name','DESC')
            ->get();
        $data['product']=product::orderBy('id','DESC')->where('products.status',1)->paginate(5);
        return view('index')->with($data);
    } 
    public function single($slug='')
    {   
        $data['category'] = DB::table('categorys')                                
            ->select('name','slug')            
            ->orderBy('name','DESC')
            ->get();
        $data['single']=product::where('slug', $slug)               
               ->get();        
        $data['category_single']=category::find($data['single'][0]->categorys_id);                       
        $data['tag'] = DB::table('products')                    
            ->join('product_tags','products.id','=','product_tags.products_id')
            ->join('tags','product_tags.tags_id','=','tags.id')            
            ->select('tags.name','tags.slug')
            ->where('products.id',$data['single'][0]->id)
            ->orderBy('products.id','DESC')
            ->get();
        $data['related_product']=DB::table('products')
                                ->join('categorys','products.categorys_id','=','categorys.id')
                                ->select('products.title','products.image','products.slug','products.price')
                                ->orderBy('products.id','DESC')                                                             
                                ->whereNotIn('products.slug', [$slug])
                                ->where('products.categorys_id',$data['single'][0]->categorys_id)
                                ->where('products.status',1)
                                ->paginate(5);
        return view('single')->with($data);
    }
    public function category($slug='')
    {    
        $data['category'] = DB::table('categorys')                                
            ->select('name','slug')            
            ->orderBy('name','DESC')
            ->get();
        $data['single']=category::where('slug','=', $slug)->get();
        // --- cek kembali order hampir wher or and array
        $cat_count=category::where('parent_id','=', $data['single'][0]->id)->get()->count();      
        $cat_parent=category::where('parent_id','=', $data['single'][0]->id)->get();      
        $str = '';
        for( $i = 0; $i <=$cat_count-1; $i++ ) {
            $str .= $cat_parent[$i]->id . ',';    
        }               
        echo substr($str, 0, -1);
        $data['product']=DB::table('products')
                                ->join('categorys','products.categorys_id','=','categorys.id')
                                ->select('products.title','products.image','products.slug','products.price')
                                ->orderBy('products.id','DESC')                                
                                ->orwhere('products.categorys_id',$data['single'][0]->id)
                                ->orWhereIn('products.categorys_id', [substr($str, 0, -1)])
                                ->where('products.status',1)                                
                                ->paginate(5);
        return view('category')->with($data);
    }
    public function tag($slug='')
    {    
        $data['category'] = DB::table('categorys')                                
            ->select('name','slug')            
            ->orderBy('name','DESC')
            ->get();
        $data['single']=tag::where('slug','=', $slug)->get();                                            
        $data['product']=DB::table('products')
                                ->join('product_tags','products.id','=','product_tags.products_id')
                                ->join('tags','product_tags.tags_id','=','tags.id')                                
                                ->select('products.title','products.image','products.slug','products.price')
                                ->orderBy('products.id','DESC')                                                            
                                ->where('product_tags.tags_id',$data['single'][0]->id)
                                ->where('products.status',1)
                                ->paginate(5);
        return view('tag')->with($data);
    }       
    // ajax
    public function get_product(Request $request)
    {
        $data['product']=product::orderBy('id','DESC')->where('products.status',1)->paginate(5);
        return view('product')->with($data);
    }
    public function get_related_product(Request $request)
    {           
        $data['product']=DB::table('products')
                                ->join('categorys','products.categorys_id','=','categorys.id')
                                ->select('products.title','products.image','products.slug','products.price')
                                ->orderBy('products.id','DESC')
                                ->whereNotIn('products.slug', [$request['product_slug']])                              
                                ->where('products.categorys_id',$request['id_category'])
                                ->where('products.status',1)
                                ->paginate(5);                            
        return view('product')->with($data);
    }
    public function get_category(Request $request)
    {           
        $data['product']=DB::table('products')
                                ->join('categorys','products.categorys_id','=','categorys.id')
                                ->select('products.title','products.image','products.slug','products.price')
                                ->orderBy('products.id','DESC')                                
                                ->where('products.categorys_id',$request['id_category'])
                                ->where('products.status',1)
                                ->paginate(5);                            
        return view('product')->with($data);
    }
    public function get_tag(Request $request)
    {                             
        $data['product']=DB::table('products')
                                ->join('product_tags','products.id','=','product_tags.products_id')
                                ->join('tags','product_tags.tags_id','=','tags.id')                                
                                ->select('products.title','products.image','products.slug','products.price')
                                ->orderBy('products.id','DESC')                                 
                                ->where('product_tags.tags_id',$request['id_tag'])
                                ->where('products.status',1)
                                ->paginate(5);
        return view('product')->with($data);
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
                return response()->json(['success' => 'true']);
                
           }else{
                return response()->json(['error' => 'Password Salah']);    
           }
        }

    }    
    
}
