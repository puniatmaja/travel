'use strict';

app.controller('KategoriGaleri', ['$scope','$http','$cookieStore','$state','$location','toaster', function($scope,$http,$cookieStore,$state,$location,toaster) {        
  if (!$cookieStore.get('auth')) {
    $state.go('access.signin');   
  }
    
    $scope.files = [];  
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
          
          $http.post(baseurl+'admin/galeri_kategori', $scope.form)
          .then(function successCallback(response) {
            toaster.pop('success', 'Berhasil','Membuat Kategori');
            $('#submit').removeClass('disabled').addClass('btn-addon');
            $('#load').addClass('glyphicon glyphicon-floppy-saved').removeClass('fa fa-circle-o-notch fa-spin');
            $location.path('/app/galeri/kategori');
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

app.controller('KategoriGaleriRubah', ['$scope','$http','$cookieStore','$state','$location','$stateParams','toaster', function($scope,$http,$cookieStore,$state,$location,$stateParams,toaster) {    
  if (!$cookieStore.get('auth')) {
    $state.go('access.signin');   
  }
    
    $scope.files = [];

    $http.get(baseurl+'admin/galeri_kategori/'+$stateParams.id).success(function(data) {
      $scope.image_source = baseurl+'gambar/thumb/'+data.gambar; 
      $scope.row=data;
      if (data.status == 1) {
        $scope.row.status = true ;
      }else{$scope.row.status = false; }  
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
        $http.put(baseurl+'admin/galeri_kategori_update/'+$stateParams.id, $scope.row)
        .then(function successCallback(response) {
          toaster.pop('success', 'Berhasil','Merubah Kategori');            
          $('#submit').removeClass('disabled').addClass('btn-addon');
          $('#load').addClass('glyphicon glyphicon-floppy-saved').removeClass('fa fa-circle-o-notch fa-spin');
          $location.path('/app/galeri/kategori');
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

  // sosialmedia controller
app.controller('SemuaKategoriGaleri', ['$scope','$http','$cookieStore','$state','$location','$modal','toaster','$timeout', function($scope,$http,$cookieStore,$state,$location,$modal,toaster,$timeout) {    
  if (!$cookieStore.get('auth')) {
    $state.go('access.signin');   
  }
  $scope.url_link = baseurl+'gallery/';
  $scope.gambar = baseurl+'gambar/thumb/';  
  $http.get(baseurl+'admin/all_galeri_kategori').success(function(data) {
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
      $http.delete(baseurl+'admin/galeri_kategori/'+id)
      .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menghapus Kategori');
        $http.get(baseurl+'admin/all_galeri_kategori').success(function(data) {
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


app.controller('Hapus', ['$scope', '$modalInstance',  function($scope, $modalInstance) {
  $scope.ok = function () {
    $modalInstance.close();
  };
  $scope.cancel = function () {
    $modalInstance.dismiss('cancel');
  };
}]); 


app.controller('Semua_Galeri', ['$scope', 'FileUploader','toaster','$http','$cookieStore','$state','$timeout','$modal', function($scope, FileUploader,toaster,$http,$cookieStore,$state,$timeout,$modal) {        
  if (!$cookieStore.get('auth')) {
    $state.go('access.signin');   
  }
  $scope.path = baseurl+'galeri/'; 
  $http.get(baseurl+'admin/all_galeri_kategori').success(function(data) {    
    $scope.kategori=data;          

  });

  var uploader = $scope.uploader = new FileUploader({        
      url: baseurl+'upload.php',        
  });
  // FILTERS        
  uploader.filters.push({
      name: 'syncFilter',
      fn: function(item /*{File|FileLikeObject}*/, options) {            
          return this.queue.length < 20;
      }
  });

  $http.get(baseurl+'admin/galeri').success(function(data) {
    $scope.dataset=data;
    $timeout(function(){
        $('.table').trigger('footable_redraw').trigger('footable_resize').trigger('footable_initialized');        
    }, 100); 
  }); 
  // CALLBACKS
 
  uploader.onCompleteItem = function(fileItem, response, status, headers) {        
      $http.post(baseurl+'admin/galeri_baru', {text:fileItem.file.name,kategori:$scope.form.kategori})
      .then(function successCallback(response) {          
      }, function errorCallback(response) {                    
        toaster.pop('warning', 'Gagal','Masukan Kategori!');
      });       
  };
  uploader.onCompleteAll = function() {
      toaster.pop('success', 'Berhasil','Mengupload Semua Galeri');
      uploader.clearQueue();
      $http.get(baseurl+'admin/galeri').success(function(data) {
        $scope.dataset=data;    
        $timeout(function(){
          $('.table').trigger('footable_redraw').trigger('footable_resize').trigger('footable_initialized');        
        }, 100);
      }); 
  };    


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
      $http.delete(baseurl+'admin/galeri_hapus/'+id)
      .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menghapus Galeri');        
        $http.get(baseurl+'admin/galeri').success(function(data) {
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

app.controller('GaleriRubah', ['$scope','$http','$cookieStore','$state','$location','$stateParams','toaster', function($scope,$http,$cookieStore,$state,$location,$stateParams,toaster) {    
  if (!$cookieStore.get('auth')) {
    $state.go('access.signin');   
  }
    
    $http.get(baseurl+'admin/all_galeri_kategori').success(function(data) {
      $scope.kategori=data;          
    }); 
        
    $http.get(baseurl+'admin/galeri/'+$stateParams.id).success(function(data) {
      $scope.row=data;      
    });     
    
    $scope.save = function() {  
                   
      $('#submit').addClass('disabled').removeClass('btn-addon');
      $('#load').removeClass('glyphicon glyphicon-floppy-saved').addClass('fa fa-circle-o-notch fa-spin');                   
      
      $http.put(baseurl+'admin/galeri/'+$stateParams.id, $scope.row)
      .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Merubah Galeri');            
        $('#submit').removeClass('disabled').addClass('btn-addon');
        $('#load').addClass('glyphicon glyphicon-floppy-saved').removeClass('fa fa-circle-o-notch fa-spin');
        console.log($scope.row);
        $location.path('/app/galeri/semua_galeri');
      }, function errorCallback(response) {                    
        toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');
        $('#submit').removeClass('disabled').addClass('btn-addon');
        $('#load').addClass('glyphicon glyphicon-floppy-saved').removeClass('fa fa-circle-o-notch fa-spin');

      });          
      
    }

  
}]);