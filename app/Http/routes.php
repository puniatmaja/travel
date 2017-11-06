<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Middleware\MyMiddleware;

// home single
Route::get('/', 'FrontController@index'); 
Route::get('link/{slug}', 'FrontController@single_product');
Route::get('category/all', 'FrontController@list_product');
Route::get('category', 'FrontController@list_product');
Route::get('category/{slug}', 'FrontController@list_product');
Route::get('blog', 'FrontController@list_blog');
Route::get('blog/{slug}', 'FrontController@single_blog');
Route::get('blog/category/{slug}', 'FrontController@list_blog');
Route::get('tag/{slug}', 'FrontController@list_tag');

Route::get('gallery.html', 'FrontController@list_gallery');
Route::get('gallery/{slug}', 'FrontController@list_gallery');

Route::get('search', 'FrontController@search');
Route::get('contact.html', 'FrontController@contact');
Route::get('booking.html', 'FrontController@booking');

//post
Route::post('contact', 'FrontController@contact_send');
Route::post('booking', 'FrontController@booking_send');
Route::post('single_booking', 'FrontController@single_send');
Route::post('home_booking', 'FrontController@home_send');



Route::get('apps','adminController@angular');
// admin
// Route::get('dashboard','adminController@angular')->middleware(MyMiddleware::class);

// booking
Route::get('admin/booking','adminController@booking_list');
Route::get('admin/booking/{id}','adminController@booking_single');
Route::delete('admin/booking/{id}','adminController@booking_hapus');

//profile website
Route::get('admin/profile_website', 'adminController@profile_website');
Route::put('admin/profile_website', 'adminController@profile_website_update');
Route::put('admin/profile_website_logo', 'adminController@profile_website_logo');
Route::put('admin/profile_website_gambar', 'adminController@profile_website_gambar');

//sosial_media
Route::get('admin/sosial_media', 'adminController@sosial_media');
Route::post('admin/sosial_media', 'adminController@sosial_media_baru');
Route::delete('admin/sosial_media/{id}', 'adminController@hapus_sosial_media');
Route::get('admin/sosial_media_rubah/{id}','adminController@sosial_media_rubah');
Route::put('admin/sosial_media_update/{id}','adminController@sosial_media_update');
Route::put('admin/sosial_media_ikon/{id}','adminController@sosial_media_ikon');

//kontak
Route::get('admin/kontak', 'adminController@kontak');
Route::post('admin/kontak', 'adminController@kontak_baru');
Route::delete('admin/kontak/{id}', 'adminController@hapus_kontak');
Route::get('admin/kontak_rubah/{id}','adminController@kontak_rubah');
Route::put('admin/kontak_update/{id}','adminController@kontak_update');

// administrator
Route::get('admin/administrator', 'adminController@administrator');
Route::post('admin/administrator', 'adminController@add_administrator');
Route::get('admin/administrator/{id}', 'adminController@administrator_edit');
Route::put('admin/administrator/{id}', 'adminController@administrator_update');
Route::delete('admin/administrator/{id}', 'adminController@delete_administrator');

// blog
Route::get('admin/all_blog_kategori', 'adminController@blog_kategori');
Route::post('admin/blog_kategori','adminController@blog_kategori_baru');
Route::get('admin/blog_kategori/{id}','adminController@blog_kategori_rubah');
Route::put('admin/blog_kategori_update/{id}','adminController@blog_kategori_update');
Route::delete('admin/blog_kategori/{id}', 'adminController@hapus_kategori_blog');

Route::post('admin/blog_baru','adminController@blog_baru');
Route::get('admin/blog/{id}','adminController@blog_rubah');
Route::get('admin/all_blog','adminController@get_all_blog');
Route::put('admin/blog_update/{id}','adminController@blog_update');
Route::get('admin/get_tag_blog/{id}','adminController@get_tag_blog');
Route::delete('admin/blog/{id}', 'adminController@hapus_blog');

// produk
Route::get('admin/all_kategori', 'adminController@kategori');
Route::post('admin/kategori','adminController@kategori_baru');
Route::get('admin/kategori/{id}','adminController@kategori_rubah');
Route::put('admin/kategori_update/{id}','adminController@kategori_update');
Route::delete('admin/kategori/{id}', 'adminController@hapus_kategori');

Route::post('admin/produk_baru','adminController@product_baru');
Route::get('admin/produk/{id}','adminController@product_rubah');
Route::get('admin/all_produk','adminController@get_all_product');
Route::put('admin/produk_update/{id}','adminController@product_update');
Route::get('admin/get_tag_produk/{id}','adminController@get_tag_product');
Route::delete('admin/produk/{id}', 'adminController@hapus_product');

//product gambar get
Route::post('admin/key_up_product','adminController@product_key_up_update');
Route::get('admin/product_gambar/{id}','adminController@get_product_gambar');
Route::post('admin/product_gambar','adminController@product_gambar');
Route::delete('admin/product_gambar/{id}', 'adminController@hapus_product_gambar');

//page
Route::post('admin/page_baru','adminController@page_baru');
Route::get('admin/page/{id}','adminController@page_rubah');
Route::get('admin/all_page','adminController@get_all_page');
Route::put('admin/page_update/{id}','adminController@page_update');
Route::delete('admin/page/{id}', 'adminController@hapus_page');

//galeri
Route::get('admin/all_galeri_kategori', 'adminController@galeri_kategori');
Route::post('admin/galeri_kategori','adminController@galeri_kategori_baru');
Route::get('admin/galeri_kategori/{id}','adminController@galeri_kategori_rubah');
Route::put('admin/galeri_kategori_update/{id}','adminController@galeri_kategori_update');
Route::delete('admin/galeri_kategori/{id}', 'adminController@hapus_kategori_galeri');

Route::post('admin/galeri_baru','adminController@galeri_baru');
Route::get('admin/galeri','adminController@galeri');
Route::get('admin/galeri/{id}','adminController@galeri_rubah');
Route::put('admin/galeri/{id}','adminController@galeri_update');
Route::delete('admin/galeri_hapus/{id}','adminController@galeri_hapus');

//slider
Route::post('admin/slider_baru','adminController@slider_baru');
Route::get('admin/slider','adminController@slider');
Route::get('admin/slider/{id}','adminController@slider_rubah');
Route::put('admin/slider/{id}','adminController@slider_update');
Route::delete('admin/slider_hapus/{id}','adminController@slider_hapus');

//home setting
	Route::get('admin/home_setting','adminController@home_setting');
	Route::put('admin/home_setting/{id}','adminController@home_setting_update');
	Route::put('admin/kategori_setting/{id}','adminController@kategori_setting');
	Route::post('admin/select_product','adminController@select_product');
	Route::post('admin/spesial_produk','adminController@spesial_produk');
	Route::post('admin/spesial_produk_page','adminController@spesial_produk_page');
	Route::delete('admin/special_hapus/{id}','adminController@special_hapus');	
	Route::put('admin/setting_active/{id}','adminController@setting_active');
	Route::get('admin/setting_special','adminController@get_special');
	// move
	Route::get('admin/setting_up/{id}','adminController@setting_up');
	Route::get('admin/setting_down/{id}','adminController@setting_down');
	//special oggert
	Route::get('admin/get_kategori_produk','adminController@get_special_kategori');	

//home setting tag
	Route::get('admin/all_tag', 'adminController@tag');
	Route::get('admin/tag/{id}','adminController@tag_rubah');
	Route::put('admin/tag_update/{id}','adminController@tag_update');
	Route::delete('admin/tag/{id}', 'adminController@hapus_tag');

	//menu
	Route::post('admin/menu','adminController@menu_baru');
	Route::put('admin/menu/{id}','adminController@menu_update');
	Route::get('admin/menu','adminController@get_menu');	
	Route::delete('admin/menu/{id}','adminController@menu_hapus');
	// move
	Route::get('admin/menu_up/{id}','adminController@menu_up');
	Route::get('admin/menu_down/{id}','adminController@menu_down');	
// home setting footer
	// footer
	Route::get('admin/footer/{posisi}','adminController@get_footer');
	Route::post('admin/footer','adminController@add_footer');
	Route::get('admin/get_footer/{id}','adminController@edit_footer');
	Route::put('admin/footer/{id}','adminController@update_footer');
	Route::delete('admin/footer/{id}','adminController@footer_hapus');
	//menu_footer	
	Route::post('admin/menu_footer','adminController@menu_footer');
	Route::get('admin/menu_footer','adminController@get_menu_footer');
	Route::get('admin/menu_footer/{id}','adminController@edit_menu_footer');
	Route::put('admin/menu_footer/{id}','adminController@update_menu_footer');
	Route::delete('admin/menu_footer/{id}','adminController@menu_footer_hapus');
// end admin

// login
Route::get('admin/auth', 'FrontController@login');
Route::post('admin/auth', 'FrontController@log_in');
Route::get('admin/logout', 'adminController@logout');

Route::get('sitemap.xml','SitemapsController@index');
//page
Route::get('/{slug}', 'FrontController@single_page');
