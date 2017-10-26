<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Sitemap;
use DB;

class SitemapsController extends Controller
{
    public function index(){
        Sitemap::addTag(url(), '', 'daily', '1.0');
        Sitemap::addTag(url('gallery.html'), '', 'daily', '1.0');
        Sitemap::addTag(url('contact.html'), '', 'daily', '1.0');
        Sitemap::addTag(url('booking.html'), '', 'daily', '1.0');
        Sitemap::addTag(url('blog.html'), '', 'daily', '1.0');
        Sitemap::addTag(url('category/all'), '', 'daily', '1.0');
        Sitemap::addTag(url('category'), '', 'daily', '1.0');                

    $page = DB::table('page')->where('status','=',1)->get();
    foreach ($page as $pages)
    {        
        Sitemap::addTag(url().'/'.$pages->slug, $pages->updated_at, 'monthly', '0.9');
    }
    $list_product = DB::table('product')                   
                    ->where('status','=',1)->get();
    foreach ($list_product as $list_products)
    {        
        Sitemap::addTag(url('link').'/'.$list_products->slug, $list_products->updated_at, 'monthly', '0.9');
    }
    $list_blog = DB::table('blog')                    
                    ->where('status','=',1)             
                    ->get();
    foreach ($list_blog as $list_blogs)
    {        
        Sitemap::addTag(url('blog').'/'.$list_blogs->slug, $list_blogs->updated_at, 'monthly', '0.9');
    }
    $list_tag = DB::table('tag')->get();
    foreach ($list_tag as $list_tags)
    {        
        Sitemap::addTag(url('tag').'/'.$list_tags->slug, $list_tags->updated_at, 'monthly', '0.9');
    }   
    $list_gallery = DB::table('galeri_kategori')->where('status','=',1)->get();
    foreach ($list_gallery as $list_gallerys)
    {        
        Sitemap::addTag(url('gallery').'/'.$list_gallerys->slug, $list_gallerys->updated_at, 'monthly', '0.9');
    }
    $list_blog_categori = DB::table('blog_kategori')->get();
    foreach ($list_blog_categori as $list_blog_categoris)
    {        
        Sitemap::addTag(url('blog/category').'/'.$list_blog_categoris->slug, $list_blog_categoris->updated_at, 'monthly', '0.9');
    }
    $list_categori = DB::table('kategori')->get();
    foreach ($list_categori as $list_categoris)
    {        
        Sitemap::addTag(url('category').'/'.$list_categoris->slug, $list_categoris->updated_at, 'monthly', '0.9');
    }

    return Sitemap::renderSitemap();
     
    }
}
