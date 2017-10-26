'use strict';

/**
 * Config for the router
 */
angular.module('app')
  .run(
    [          '$rootScope', '$state', '$stateParams','$cookieStore',
      function ($rootScope,   $state,   $stateParams,$cookieStore) {
          $rootScope.$state = $state;
          $rootScope.$stateParams = $stateParams;                                                      
      }
    ]
  )
  .config(
    [          '$stateProvider', '$urlRouterProvider',
      function ($stateProvider,   $urlRouterProvider) {
          
          $urlRouterProvider
              .otherwise('/access/signin');
          $stateProvider
              .state('app', {
                  abstract: true,
                  url: '/app',
                  templateUrl: 'tpl/app.html',                  
                  resolve: {
                      deps: ['$ocLazyLoad',
                        function( $ocLazyLoad){
                          return $ocLazyLoad.load('toaster').then(
                              function(){
                                 return $ocLazyLoad.load('js/controllers/toaster.js');
                              }
                          );
                      }]
                  }
              })
              .state('app.dashboard', {
                  url: '/dashboard',
                  templateUrl: 'tpl/app_dashboard_v1.html',                  
                  authenticate: true,
                  resolve: {
                    deps: ['$ocLazyLoad',
                      function( $ocLazyLoad ){
                        return $ocLazyLoad.load(['js/controllers/dsh/dashboard.js']);
                    }]
                  } 
              })                                                      
              //blog
              .state('app.blog', {
                  url: '/blog',
                  template: '<div ui-view class="fade-in"></div>',
                  resolve: {
                      deps: ['$ocLazyLoad','uiLoad',
                        function($ocLazyLoad,uiLoad){
                          return uiLoad.load('js/controllers/dsh/blog.js');
                      }]                      
                  }
              })                                  
              .state('app.blog.semua_blog', {
                  url: '/semua_blog',
                  templateUrl: 'tpl/front/blog/semua.html'
              })              
              .state('app.blog.blog_baru', {
                  url: '/blog_baru',
                  templateUrl: 'tpl/front/blog/baru.html',
                  resolve: {
                      deps: ['$ocLazyLoad',
                        function( $ocLazyLoad, ){
                          return $ocLazyLoad.load(['ngTagsInput','ui.tinymce']);
                      }]
                  }
              })
              .state('app.blog.blog_rubah', {
                  url: '/blog_rubah/:id',
                  templateUrl: 'tpl/front/blog/rubah.html',
                  resolve: {
                      deps: ['$ocLazyLoad',
                        function( $ocLazyLoad ){                                                    
                          return $ocLazyLoad.load(['ui.tinymce','ngTagsInput']); 
                      }]
                  }
              })              
              .state('app.blog.kategori', {
                  url: '/kategori',
                  templateUrl: 'tpl/front/blog/kategori.html'
              })
              .state('app.blog.kategori_baru', {
                  url: '/kategori_baru',
                  templateUrl: 'tpl/front/blog/kategori_baru.html',
                  resolve: {
                      deps: ['$ocLazyLoad',
                        function( $ocLazyLoad){
                          return $ocLazyLoad.load('ngImgCrop')
                      }]
                  }
              })
              .state('app.blog.kategori_rubah', {
                  url: '/kategori_rubah/:id',
                  templateUrl: 'tpl/front/blog/kategori_rubah.html',
                  resolve: {
                      deps: ['$ocLazyLoad',
                        function( $ocLazyLoad){
                          return $ocLazyLoad.load('ngImgCrop')
                      }]
                  }
              })
              //produk
              .state('app.produk', {
                  url: '/produk',
                  template: '<div ui-view class="fade-in"></div>',
                  resolve: {
                      deps: ['$ocLazyLoad','uiLoad',
                        function($ocLazyLoad,uiLoad){
                          return uiLoad.load('js/controllers/dsh/produk.js');
                      }]                      
                  }
              })                                  
              .state('app.produk.semua_produk', {
                  url: '/semua_produk',
                  templateUrl: 'tpl/front/produk/semua.html'
              })              
              .state('app.produk.produk_baru', {
                  url: '/produk_baru',
                  templateUrl: 'tpl/front/produk/baru.html',
                  resolve: {
                      deps: ['$ocLazyLoad',
                        function( $ocLazyLoad, ){
                          return $ocLazyLoad.load(['ui.tinymce','ngTagsInput','angularFileUpload']);
                      }]
                  }
              })
              .state('app.produk.produk_rubah', {
                  url: '/produk_rubah/:id',
                  templateUrl: 'tpl/front/produk/rubah.html',
                  resolve: {
                      deps: ['$ocLazyLoad',
                        function( $ocLazyLoad ){                                                    
                          return $ocLazyLoad.load(['ui.tinymce','ngTagsInput','angularFileUpload']); 
                      }]
                  }
              })              
              .state('app.produk.kategori', {
                  url: '/kategori',
                  templateUrl: 'tpl/front/produk/kategori.html'
              })
              .state('app.produk.kategori_baru', {
                  url: '/kategori_baru',
                  templateUrl: 'tpl/front/produk/kategori_baru.html',
                  resolve: {
                      deps: ['$ocLazyLoad',
                        function( $ocLazyLoad){
                          return $ocLazyLoad.load('ngImgCrop')
                      }]
                  }
              })
              .state('app.produk.kategori_rubah', {
                  url: '/kategori_rubah/:id',
                  templateUrl: 'tpl/front/produk/kategori_rubah.html',
                  resolve: {
                      deps: ['$ocLazyLoad',
                        function( $ocLazyLoad){
                          return $ocLazyLoad.load('ngImgCrop')
                      }]
                  }
              })
              //page
              .state('app.page', {
                  url: '/page',
                  template: '<div ui-view class="fade-in"></div>',
                  resolve: {
                      deps: ['$ocLazyLoad','uiLoad',
                        function($ocLazyLoad,uiLoad){
                          return uiLoad.load('js/controllers/dsh/page.js');
                      }]                      
                  }
              })                                  
              .state('app.page.semua_page', {
                  url: '/semua_page',
                  templateUrl: 'tpl/front/page/semua.html'
              })              
              .state('app.page.page_baru', {
                  url: '/page_baru',
                  templateUrl: 'tpl/front/page/baru.html',
                  resolve: {
                      deps: ['$ocLazyLoad',
                        function( $ocLazyLoad, ){
                          return $ocLazyLoad.load('ui.tinymce');
                      }]
                  }
              })
              .state('app.page.page_rubah', {
                  url: '/page_rubah/:id',
                  templateUrl: 'tpl/front/page/rubah.html',
                  resolve: {
                      deps: ['$ocLazyLoad',
                        function( $ocLazyLoad ){                                                    
                          return $ocLazyLoad.load('ui.tinymce'); 
                      }]
                  }
              })              
            
              //galeri
              .state('app.galeri', {
                  url: '/galeri',
                  template: '<div ui-view class="fade-in"></div>',
                  resolve: {
                      deps: ['uiLoad',
                        function( uiLoad){
                          return uiLoad.load('js/controllers/dsh/galeri.js');
                      }]
                  }
              })               
              .state('app.galeri.semua_galeri', {
                  url: '/semua_galeri',
                  templateUrl: 'tpl/front/galeri/semua.html',
                  resolve: {
                      deps: ['$ocLazyLoad',
                        function( $ocLazyLoad){
                          return $ocLazyLoad.load('angularFileUpload');
                      }]
                  }
              })                     
              .state('app.galeri.kategori', {
                  url: '/kategori',
                  templateUrl: 'tpl/front/galeri/kategori.html',                  
              })
              .state('app.galeri.kategori_baru', {
                  url: '/kategori_baru',
                  templateUrl: 'tpl/front/galeri/kategori_baru.html',
                  resolve: {
                      deps: ['$ocLazyLoad',
                        function( $ocLazyLoad){
                          return $ocLazyLoad.load('ngImgCrop')
                      }]
                  }
              })
              .state('app.galeri.kategori_rubah', {
                  url: '/kategori_rubah/:id',
                  templateUrl: 'tpl/front/galeri/kategori_rubah.html',
                  resolve: {
                      deps: ['$ocLazyLoad',
                        function( $ocLazyLoad){
                          return $ocLazyLoad.load('ngImgCrop')
                      }]
                  }
              })
              .state('app.galeri.rubah', {
                  url: '/rubah/:id',
                  templateUrl: 'tpl/front/galeri/rubah.html'
              })
              //setting
              .state('app.setting', {
                  url: '/setting',
                  template: '<div ui-view class="fade-in"></div>',
                  resolve: {
                      deps: ['$ocLazyLoad','uiLoad',
                        function($ocLazyLoad,uiLoad){
                          return uiLoad.load('js/controllers/dsh/setting.js');
                      }]                      
                  }
              })      
              //slider
              .state('app.setting.semua_slider', {
                  url: '/semua_slider',
                  templateUrl: 'tpl/front/setting/slider.html',
                  resolve: {
                      deps: ['$ocLazyLoad',
                        function( $ocLazyLoad){
                          return $ocLazyLoad.load('angularFileUpload');
                      }]
                  }
              })
              .state('app.setting.slider_rubah', {
                  url: '/slider_rubah/:id',
                  templateUrl: 'tpl/front/setting/slider_rubah.html'
              })             
              //menu
              .state('app.setting.menu', {
                  url: '/menu',
                  templateUrl: 'tpl/front/setting/menu.html',
              })
              .state('app.setting.menu_tambahan', {
                  url: '/menu_tambahan',
                  templateUrl: 'tpl/front/setting/menu_tambahan.html',
              })
              .state('app.setting.footer', {
                  url: '/footer',
                  templateUrl: 'tpl/front/setting/footer.html',
              })
              //special_offer
              .state('app.setting.special_offer', {
                  url: '/special_offer',
                  templateUrl: 'tpl/front/setting/special_offer.html',
              })
              //Home_setting
              .state('app.setting.home_setting', {
                  url: '/home_setting',
                  templateUrl: 'tpl/front/setting/home_setting.html',
              })
              // sosial_media              
              .state('app.setting.sosial_media', {
                  url: '/sosial_media',
                  templateUrl: 'tpl/front/setting/sosial_media.html',
              })
              .state('app.setting.sosial_media_baru', {
                  url: '/sosial_media_baru',
                  templateUrl: 'tpl/front/setting/sosial_media_baru.html',
                  resolve: {
                      deps: ['$ocLazyLoad',
                        function( $ocLazyLoad){
                          return $ocLazyLoad.load('ngImgCrop')
                      }]
                  }
              })
              .state('app.setting.sosial_media_rubah', {
                  url: '/sosial_media_rubah/:id',
                  templateUrl: 'tpl/front/setting/sosial_media_rubah.html',
                  resolve: {
                      deps: ['$ocLazyLoad',
                        function( $ocLazyLoad){
                          return $ocLazyLoad.load('ngImgCrop')
                      }]
                  }
              })
              .state('app.setting.sosial_media_ikon', {
                  url: '/sosial_media_ikon/:id',
                  templateUrl: 'tpl/front/setting/sosial_media_ikon.html',
                  resolve: {
                      deps: ['$ocLazyLoad',
                        function( $ocLazyLoad){
                          return $ocLazyLoad.load('ngImgCrop')
                      }]
                  }
              })
              // Kontak
              .state('app.setting.kontak', {
                  url: '/kontak',
                  templateUrl: 'tpl/front/setting/kontak.html',
              })
              .state('app.setting.kontak_baru', {
                  url: '/kontak_baru',
                  templateUrl: 'tpl/front/setting/kontak_baru.html',
                  resolve: {
                      deps: ['$ocLazyLoad',
                        function( $ocLazyLoad){
                          return $ocLazyLoad.load('ngImgCrop')
                      }]
                  }
              })
              .state('app.setting.kontak_rubah', {
                  url: '/kontak_rubah/:id',
                  templateUrl: 'tpl/front/setting/kontak_rubah.html',
                  resolve: {
                      deps: ['$ocLazyLoad',
                        function( $ocLazyLoad){
                          return $ocLazyLoad.load('ngImgCrop')
                      }]
                  }
              })
              .state('app.setting.kontak_ikon', {
                  url: '/sosial_media_ikon/:id',
                  templateUrl: 'tpl/front/setting/kontak_ikon.html',
                  resolve: {
                      deps: ['$ocLazyLoad',
                        function( $ocLazyLoad){
                          return $ocLazyLoad.load('ngImgCrop')
                      }]
                  }
              })
              // admin
              .state('app.setting.admin', {
                  url: '/admin',
                  templateUrl: 'tpl/front/setting/admin.html'
              })
              .state('app.setting.admin_baru', {
                  url: '/admin_baru',
                  templateUrl: 'tpl/front/setting/admin_baru.html'
              })
              .state('app.setting.admin_rubah', {
                  url: '/admin_rubah/:id',
                  templateUrl: 'tpl/front/setting/admin_rubah.html'
              })
              //profile web
              .state('app.setting.profile_website', {
                  url: '/profile_website',
                  templateUrl: 'tpl/front/setting/profile_website.html',   
                  resolve: {
                      deps: ['$ocLazyLoad',
                        function( $ocLazyLoad, ){
                          return $ocLazyLoad.load(['textAngular']);
                      }]
                  }                                
              })              
              .state('app.setting.webmaster', {
                  url: '/webmaster',
                  templateUrl: 'tpl/front/setting/webmaster.html',                  
              })
              .state('app.setting.logo', {
                  url: '/logo',
                  templateUrl: 'tpl/front/setting/logo.html',                 
              })
              .state('app.setting.gambar', {
                  url: '/gambar',
                  templateUrl: 'tpl/front/setting/gambar.html',
                  resolve: {
                      deps: ['$ocLazyLoad',
                        function( $ocLazyLoad){
                          return $ocLazyLoad.load('ngImgCrop')
                      }]
                  }
              })
              //tag
              .state('app.setting.tag', {
                  url: '/tag',
                  templateUrl: 'tpl/front/setting/tag.html'
              })              
              .state('app.setting.tag_rubah', {
                  url: '/tag_rubah/:id',
                  templateUrl: 'tpl/front/setting/tag_rubah.html',
                  resolve: {
                      deps: ['$ocLazyLoad',
                        function( $ocLazyLoad){
                          return $ocLazyLoad.load('ngImgCrop')
                      }]
                  }
              })              
              .state('access', {
                  url: '/access',
                  authenticate: true,
                  template: '<div ui-view class="fade-in-right-big smooth"></div>'
              })
              .state('access.signin', {
                  url: '/signin',
                  templateUrl: 'tpl/page_signin.html',                  
                  resolve: {
                      deps: ['uiLoad',
                        function( uiLoad ){
                          return uiLoad.load( ['js/controllers/signin.js'] );
                      }]
                  }
              }).state('access.logout', {
                  url: '/logout',
                  templateUrl: 'tpl/page_logout.html',                  
                  resolve: {
                      deps: ['uiLoad',
                        function( uiLoad ){
                          return uiLoad.load( ['js/controllers/signin.js'] );
                      }]
                  }
              })
      }
    ]
  );