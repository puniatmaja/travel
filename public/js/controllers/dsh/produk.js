'use strict';

/* Controllers */
app.controller('Produk', ['$scope','FileUploader','$http','$location','toaster','$cookieStore','$state','$timeout', function($scope,FileUploader,$http,$location,toaster,$cookieStore,$state,$timeout) {    
    if (!$cookieStore.get('auth')) {
      $state.go('access.signin');   
    }
    $scope.tinymceOptions = {
      plugins : 'advlist autolink lists link image charmap print preview anchor searchreplace visualblocks code fullscreen insertdatetime media table paste responsivefilemanager',
      height: 300,
      menubar: false,
      relative_urls : false,
      remove_script_host : false,            
      toolbar_items_size: 'small',    
      toolbar: "formatselect | bold italic underline strikethrough blockquote | table alignleft aligncenter alignright alignjustify | outdent indent bullist | link unlink anchor | image media | code fullscreen ",  
      external_filemanager_path: baseurl+"filemanager/filemanager/",
      filemanager_title:"Filemanager" ,
      external_plugins: { "filemanager" : baseurl+"filemanager/filemanager/plugin.min.js"}
    };
    $scope.files = [];        
    $scope.path = baseurl+'gambar/thumb/';
    //get kategori
    $http.get(baseurl+'admin/all_kategori').success(function(data) {
      $scope.kategori=data;    
    }); 

    $http.post(baseurl+'admin/produk_baru', $scope.form)
    .then(function successCallback(response) {   
      $scope.id = response.data;  
    },function errorCallback(response) {                          
    });
    
    $scope.save_up = function() {     
      $scope.form.id = $scope.id;
      $http.post(baseurl+'admin/key_up_product', $scope.form)
      .then(function successCallback(response) {        
      },function errorCallback(response) {                          
      });
    }

    $scope.save = function() {      
      $('#submit').addClass('disabled').removeClass('btn-addon');
      $('#load').removeClass('glyphicon glyphicon-floppy-saved').addClass('fa fa-circle-o-notch fa-spin');                   
      
      $http.post(baseurl+'admin/produk_baru', $scope.form)
      .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Membuat Produk');
        $('#submit').removeClass('disabled').addClass('btn-addon');
        $('#load').addClass('glyphicon glyphicon-floppy-saved').removeClass('fa fa-circle-o-notch fa-spin');
        $location.path('/app/produk/semua_produk');
      }, function errorCallback(response) {                    
        toaster.pop('warning', 'Gagal','Periksa Data!');
        $('#submit').removeClass('disabled').addClass('btn-addon');
        $('#load').addClass('glyphicon glyphicon-floppy-saved').removeClass('fa fa-circle-o-notch fa-spin');
      });                

    }  
    $scope.delete = function (e) {          
      $http.delete(baseurl+'admin/product_gambar/'+e)
      .then(function successCallback(response) {          
        $http.get(baseurl+'admin/product_gambar/'+$scope.id).success(function(data) {
          $scope.album=data;          
        }); 
      }, function errorCallback(response) {                    
        toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');        
      });
    };

    var uploader = $scope.uploader = new FileUploader({        
      url: baseurl+'gambarproduct.php',        
    });
    // FILTERS        
    uploader.filters.push({
      name: 'imageFilter',
      fn: function(item /*{File|FileLikeObject}*/, options) {
          var type = '|' + item.type.slice(item.type.lastIndexOf('/') + 1) + '|';
          return '|jpg|png|jpeg|bmp|gif|'.indexOf(type) !== -1;
      }
    });
      $scope.form = {
        gambar: ''
      };   
    uploader.onCompleteItem = function(fileItem, response, status, headers) {                                  
        $http.post(baseurl+'admin/product_gambar', {text:fileItem.file.name,data:$scope.id})
        .then(function successCallback(response){          
        }, function errorCallback(response) {
        });
        if ($scope.form.gambar == '') {
          $scope.form.gambar = fileItem.file.name;
        }

    };
    uploader.onCompleteAll = function() {
        toaster.pop('success', 'Berhasil','Mengupload Semua Galeri');
        uploader.clearQueue();
        $timeout(function(){        
          $http.get(baseurl+'admin/product_gambar/'+$scope.id).success(function(data) {
            $scope.album=data;          
          }); 
        }, 100);
    };
  
}]);

app.controller('ProdukRubah', ['$scope','$http','$location','$stateParams','toaster','FileUploader','$cookieStore','$state','$timeout', function($scope,$http,$location,$stateParams,toaster,FileUploader,$cookieStore,$state,$timeout) {    
    if (!$cookieStore.get('auth')) {
      $state.go('access.signin');   
    }
    $scope.tinymceOptions = {
      plugins : 'advlist autolink lists link image charmap print preview anchor searchreplace visualblocks code fullscreen insertdatetime media table paste responsivefilemanager',
      height: 300,
      menubar: false,
      relative_urls : false,
      remove_script_host : false,            
      toolbar_items_size: 'small',    
      toolbar: "formatselect | bold italic underline strikethrough blockquote | table alignleft aligncenter alignright alignjustify | outdent indent bullist | link unlink anchor | image media | code fullscreen ",  
      external_filemanager_path: baseurl+"filemanager/filemanager/",
      filemanager_title:"Filemanager" ,
      external_plugins: { "filemanager" : baseurl+"filemanager/filemanager/plugin.min.js"}
    };
    $scope.files = [];
    $scope.path = baseurl+'gambar/thumb/';    
  
    
    //get kategori
    $http.get(baseurl+'admin/all_kategori').success(function(data) {
      $scope.kategori=data;  
      $http.get(baseurl+'admin/produk/'+$stateParams.id).success(function(data) {      
        $scope.form=data;
        if (data.status == 1) {
          $scope.form.status = true ;
        }else{$scope.form.status = false; }
        $http.get(baseurl+'admin/get_tag_produk/'+$stateParams.id).success(function(data) {
          $scope.form.tag=data;
          $http.get(baseurl+'admin/product_gambar/'+$stateParams.id).success(function(data) {
            $scope.album=data;
          });
        });        
      });  
    });


    
    $scope.save = function() {    
      $('#submit').addClass('disabled').removeClass('btn-addon');
      $('#load').removeClass('glyphicon glyphicon-floppy-saved').addClass('fa fa-circle-o-notch fa-spin');                    
      $http.put(baseurl+'admin/produk_update/'+$stateParams.id, $scope.form)
      .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Merubah Produk');
        $('#submit').removeClass('disabled').addClass('btn-addon');
        $('#load').addClass('glyphicon glyphicon-floppy-saved').removeClass('fa fa-circle-o-notch fa-spin');
        $location.path('/app/produk/semua_produk');
      }, function errorCallback(response) {                    
        toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');
        $('#submit').removeClass('disabled').addClass('btn-addon');
        $('#load').addClass('glyphicon glyphicon-floppy-saved').removeClass('fa fa-circle-o-notch fa-spin');
      });                
    }

    $scope.delete = function (e) {          
      $http.delete(baseurl+'admin/product_gambar/'+e)
      .then(function successCallback(response) {          
        $http.get(baseurl+'admin/product_gambar/'+$stateParams.id).success(function(data) {
          $scope.album=data;          
        }); 
      }, function errorCallback(response) {                    
        toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');        
      });
    };

    var uploader = $scope.uploader = new FileUploader({        
      url: baseurl+'gambarproduct.php',        
    });
    // FILTERS
    uploader.filters.push({
      name: 'imageFilter',
      fn: function(item /*{File|FileLikeObject}*/, options) {
          var type = '|' + item.type.slice(item.type.lastIndexOf('/') + 1) + '|';
          return '|jpg|png|jpeg|bmp|gif|'.indexOf(type) !== -1;
      }
    });
   
    uploader.onCompleteItem = function(fileItem, response, status, headers) {                                  
        $http.post(baseurl+'admin/product_gambar', {text:fileItem.file.name,data:$stateParams.id})
        .then(function successCallback(response){
        }, function errorCallback(response) {

        });      
    };
    uploader.onCompleteAll = function() {
        toaster.pop('success', 'Berhasil','Mengupload Semua Galeri');
        uploader.clearQueue();        
        $timeout(function(){        
          $http.get(baseurl+'admin/product_gambar/'+$stateParams.id).success(function(data) {
            $scope.album=data;          
          });
        }, 100);
    };  
  
}]);


app.controller('Kategori', ['$scope','$http','$location','toaster','$cookieStore','$state', function($scope,$http,$location,toaster,$cookieStore,$state) {    
    if (!$cookieStore.get('auth')) {
      $state.go('access.signin');   
    }
    // $scope.form = [];
    $scope.files = [];
    //get kategori
    $http.get(baseurl+'admin/all_kategori').success(function(data) {
      $scope.kategori=data;    
    }); 
    
    $scope.save = function() {  
      $scope.form.image = $scope.files[0];
      $http({
        method  : 'POST',
        url     : 'gambar.php',    
        transformRequest: function (data) {
            var formData = new FormData();
            formData.append("image", $scope.form.image);            
            return formData;  
        },  
        data : $scope.form,
        headers: {'Content-Type': undefined}
      }).success(function(data){          
          $scope.form.gambar = data;
          $('#submit').addClass('disabled').removeClass('btn-addon');
          $('#load').removeClass('glyphicon glyphicon-floppy-saved').addClass('fa fa-circle-o-notch fa-spin');                   
          
          $http.post(baseurl+'admin/kategori', $scope.form)
          .then(function successCallback(response) {
            toaster.pop('success', 'Berhasil','Membuat Kategori');
            $('#submit').removeClass('disabled').addClass('btn-addon');
            $('#load').addClass('glyphicon glyphicon-floppy-saved').removeClass('fa fa-circle-o-notch fa-spin');
            $location.path('/app/produk/kategori');
          }, function errorCallback(response) {                    
            toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');
            $('#submit').removeClass('disabled').addClass('btn-addon');
            $('#load').addClass('glyphicon glyphicon-floppy-saved').removeClass('fa fa-circle-o-notch fa-spin');

          });          
      });
    }

    $scope.uploadedFile = function(element) {
      $scope.currentFile = element.files[0];
      var reader = new FileReader();

      reader.onload = function(event) {
        $scope.image_source = event.target.result
        $scope.$apply(function($scope) {
          $scope.files = element.files;
        });
      }
      reader.readAsDataURL(element.files[0]);
    }  
  
}]);

app.controller('KategoriRubah', ['$scope','$http','$location','$stateParams','toaster','$cookieStore','$state', function($scope,$http,$location,$stateParams,toaster,$cookieStore,$state) {    
  if (!$cookieStore.get('auth')) {
    $state.go('access.signin');   
  }

    // ------------------------------
    // -------------------------------
    // --------------------------------
     
    $scope.files = [];
    //get kategori
    $http.get(baseurl+'admin/all_kategori').success(function(data) {
      $scope.kategori=data;    
    });

    $http.get(baseurl+'admin/kategori/'+$stateParams.id).success(function(data) {
      $scope.image_source = baseurl+'gambar/thumb/'+data.gambar; 
      $scope.row=data;      
    }); 
    
    $scope.save = function() {  
      $scope.row.image = $scope.files[0];
      $http({
        method  : 'POST',
        url     : 'gambar.php',    
        transformRequest: function (data) {
            var formData = new FormData();
            formData.append("image", $scope.row.image);            
            return formData;  
        },  
        data : $scope.form,
        headers: {'Content-Type': undefined}
      }).success(function(data){          
          $scope.row.gambar = data;
          $('#submit').addClass('disabled').removeClass('btn-addon');
          $('#load').removeClass('glyphicon glyphicon-floppy-saved').addClass('fa fa-circle-o-notch fa-spin');                   
                    
          $http.put(baseurl+'admin/kategori_update/'+$stateParams.id, $scope.row)
          .then(function successCallback(response) {
            toaster.pop('success', 'Berhasil','Merubah Kategori');
            $('#submit').removeClass('disabled').addClass('btn-addon');
            $('#load').addClass('glyphicon glyphicon-floppy-saved').removeClass('fa fa-circle-o-notch fa-spin');
            $location.path('/app/produk/kategori');
          }, function errorCallback(response) {                    
            toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');
            $('#submit').removeClass('disabled').addClass('btn-addon');
            $('#load').addClass('glyphicon glyphicon-floppy-saved').removeClass('fa fa-circle-o-notch fa-spin');

          });          
      });
    }

    $scope.uploadedFile = function(element) {
      $scope.currentFile = element.files[0];
      var reader = new FileReader();

      reader.onload = function(event) {
        $scope.image_source = event.target.result
        $scope.$apply(function($scope) {
          $scope.files = element.files;
        });
      }
      reader.readAsDataURL(element.files[0]);
    }
}]);


app.controller('SemuaKategori', ['$scope','$http','$location','$modal','toaster','$timeout','$cookieStore','$state', function($scope,$http,$location,$modal,toaster,$timeout,$cookieStore,$state) {      
  if (!$cookieStore.get('auth')) {
    $state.go('access.signin');   
  }
  $scope.url_link = baseurl+'category/';
  $scope.gambar = baseurl+'gambar/thumb/';  
  $http.get(baseurl+'admin/all_kategori').success(function(data) {    
    $scope.kategori=data;
    $timeout(function(){
      $('.table').trigger('footable_redraw').trigger('footable_resize').trigger('footable_initialized');        
    }, 100);
  });
  $scope.delete = function (id) {
    var modalInstance = $modal.open({
      templateUrl: 'myModalContent.html',
      controller: 'Hapus',      
      resolve: {
        items: function () {
          return $scope.items;
        }
      }
    });
    modalInstance.result.then(function () {      
      $http.delete(baseurl+'admin/kategori/'+id)
      .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menghapus Kategori');
        $http.get(baseurl+'admin/all_kategori').success(function(data) {    
          $scope.kategori=data;
          $timeout(function(){
            $('.table').trigger('footable_redraw').trigger('footable_resize').trigger('footable_initialized');        
          }, 100);
        });        
      }, function errorCallback(response) {                    
        toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');        
      });   

    }, function () {
      toaster.pop('warning', 'Batal','Batal Menghapus');  
    });
  };


}]);

app.controller('SemuaProduk', ['$scope','$http','$location','$modal','toaster','$timeout','$cookieStore','$state', function($scope,$http,$location,$modal,toaster,$timeout,$cookieStore,$state) {    
  if (!$cookieStore.get('auth')) {
    $state.go('access.signin');   
  }
  $scope.url_link = baseurl+'link/';
  $scope.gambar = baseurl+'gambar/thumb/';  
  $http.get(baseurl+'admin/all_produk').success(function(data) {
    $scope.dataset=data;
    $timeout(function(){
      $('.table').trigger('footable_redraw').trigger('footable_resize').trigger('footable_initialized');        
    }, 100); 
  });  
  $scope.delete = function (id) {
    var modalInstance = $modal.open({
      templateUrl: 'myModalContent.html',
      controller: 'Hapus',      
      resolve: {
        items: function () {
          return $scope.items;
        }
      }
    });
    modalInstance.result.then(function () {      
      $http.delete(baseurl+'admin/produk/'+id)
      .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menghapus Produk');
        $http.get(baseurl+'admin/all_produk').success(function(data) {
          $scope.dataset=data;
          $timeout(function(){
            $('.table').trigger('footable_redraw').trigger('footable_resize').trigger('footable_initialized');        
          }, 100);
        });
      }, function errorCallback(response) {                    
        toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');        
      });   

    }, function () {
      toaster.pop('warning', 'Batal','Batal Menghapus');  
    });
  };
}]);


app.controller('Hapus', ['$scope', '$modalInstance',  function($scope, $modalInstance) {

  $scope.ok = function () {
    $modalInstance.close();
  };

  $scope.cancel = function () {
    $modalInstance.dismiss('cancel');
  };
}]); 
