'use strict';

/* Controllers */

  // profile website
app.controller('ProfileWebsite', ['$scope','$http','$location','toaster','$cookieStore','$state', function($scope,$http,$location,toaster,$cookieStore,$state) {      
  if (!$cookieStore.get('auth')) {
    $state.go('access.signin');   
  }
  $scope.files = [];
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

  $http.get(baseurl+'admin/profile_website').success(function(data) {
    $scope.gambar = baseurl+'gambar/';  
    $scope.form=data;
  });    
  $scope.save = function() {    
    $http.put(baseurl+'admin/profile_website', $scope.form)
      .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Profile Website Diperbarui');         
      }, function errorCallback(response) {
        toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!')
      });    
  }

  $scope.save_logo = function() {  
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
        
        $http.put(baseurl+'admin/profile_website_logo', $scope.form)
        .then(function successCallback(response) {
          toaster.pop('success', 'Berhasil','Merubah Logo');
          $('#submit').removeClass('disabled').addClass('btn-addon');
          $('#load').addClass('glyphicon glyphicon-floppy-saved').removeClass('fa fa-circle-o-notch fa-spin');
          $location.path('/app/setting/profile_website');
        }, function errorCallback(response) {                    
          toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');
          $('#submit').removeClass('disabled').addClass('btn-addon');
          $('#load').addClass('glyphicon glyphicon-floppy-saved').removeClass('fa fa-circle-o-notch fa-spin');

        });          
    });
  }
  $scope.save_gambar = function() {  
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
        $http.put(baseurl+'admin/profile_website_gambar', $scope.form)
        .then(function successCallback(response) {
          toaster.pop('success', 'Berhasil','Merubah Logo');
          $('#submit').removeClass('disabled').addClass('btn-addon');
          $('#load').addClass('glyphicon glyphicon-floppy-saved').removeClass('fa fa-circle-o-notch fa-spin');
          $location.path('/app/setting/profile_website');
        }, function errorCallback(response) {
          toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');
          $('#submit').removeClass('disabled').addClass('btn-addon');
          $('#load').addClass('glyphicon glyphicon-floppy-saved').removeClass('fa fa-circle-o-notch fa-spin');
        });
    });
  }

}]);

 // sosialmedia controller
app.controller('SosialMedia', ['$scope','$http','$location','toaster','$cookieStore','$state', function($scope,$http,$location,toaster,$cookieStore,$state) {    
  if (!$cookieStore.get('auth')) {
    $state.go('access.signin');   
  }
  $scope.path = baseurl+'gambar/sm/';
  $scope.files = [];
  $scope.radioModel = 'sm/blog.jpg';

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
        
        $http.post(baseurl+'admin/sosial_media', $scope.form)
        .then(function successCallback(response) {
          $('#submit').removeClass('disabled').addClass('btn-addon');
          $('#load').addClass('glyphicon glyphicon-floppy-saved').removeClass('fa fa-circle-o-notch fa-spin');
          toaster.pop('success', 'Berhasil','Menambah Sosial Media');
          $location.path('/app/setting/sosial_media');  
        }, function errorCallback(response) {
          toaster.pop('warning', 'Gagal','Masukan Data Dengan Lengkap!');
          $('#submit').removeClass('disabled').addClass('btn-addon');
          $('#load').addClass('glyphicon glyphicon-floppy-saved').removeClass('fa fa-circle-o-notch fa-spin');
        });            
    });

  }

}]);

app.controller('SemuaSosialMedia', ['$scope','$http','$location','$modal','toaster','$timeout','$cookieStore','$state', function($scope,$http,$location,$modal,toaster,$timeout,$cookieStore,$state) {    
  if (!$cookieStore.get('auth')) {
    $state.go('access.signin');   
  }
  $scope.gambar = baseurl+'gambar/';  
  $http.get(baseurl+'admin/sosial_media').success(function(data) {
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
      $http.delete(baseurl+'admin/sosial_media/'+id)
      .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menghapus Sosial Media');
        $http.get(baseurl+'admin/sosial_media').success(function(data) {
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

app.controller('SosialMediaRubah', ['$scope','$http','$location','$stateParams','toaster','$cookieStore','$state', function($scope,$http,$location,$stateParams,toaster,$cookieStore,$state) {      
    if (!$cookieStore.get('auth')) {
      $state.go('access.signin');   
    }
    $http.get(baseurl+'admin/sosial_media_rubah/'+$stateParams.id).success(function(data) {      
      $scope.form=data;      
    });     
    $scope.save = function() {                  
      $('#submit').addClass('disabled').removeClass('btn-addon');
      $('#load').removeClass('glyphicon glyphicon-floppy-saved').addClass('fa fa-circle-o-notch fa-spin');                   
                
      $http.put(baseurl+'admin/sosial_media_update/'+$stateParams.id, $scope.form)
      .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Merubah Sosial Media');
        $('#submit').removeClass('disabled').addClass('btn-addon');
        $('#load').addClass('glyphicon glyphicon-floppy-saved').removeClass('fa fa-circle-o-notch fa-spin');
        $location.path('/app/setting/sosial_media');
      }, function errorCallback(response) {                    
        toaster.pop('warning', 'Gagal','Masukan Data Dengan Lengkap!');
        $('#submit').removeClass('disabled').addClass('btn-addon');
        $('#load').addClass('glyphicon glyphicon-floppy-saved').removeClass('fa fa-circle-o-notch fa-spin');

      });        
    }
   
}]);

app.controller('SosialMediaIkon', ['$scope','$http','$location','$stateParams','toaster','$cookieStore','$state', function($scope,$http,$location,$stateParams,toaster,$cookieStore,$state) {    
  if (!$cookieStore.get('auth')) {
    $state.go('access.signin');   
  }
  $scope.path = baseurl+'gambar/sm/';
  $scope.files = [];
  $scope.radioModel = 'sm/blog.jpg';

  $http.get(baseurl+'admin/sosial_media_rubah/'+$stateParams.id).success(function(data) {      
    $scope.form=data;      
  });  

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
        
        $http.put(baseurl+'admin/sosial_media_ikon/'+$stateParams.id, $scope.form)
        .then(function successCallback(response) {
          toaster.pop('success', 'Berhasil','Merubah Icon Sosial Media');
          $('#submit').removeClass('disabled').addClass('btn-addon');
          $('#load').addClass('glyphicon glyphicon-floppy-saved').removeClass('fa fa-circle-o-notch fa-spin');
          $location.path('/app/setting/sosial_media');  
        }, function errorCallback(response) {
          toaster.pop('warning', 'Gagal','Pilih Ikon Terlebih Dahulu!');
          $('#submit').removeClass('disabled').addClass('btn-addon');
          $('#load').addClass('glyphicon glyphicon-floppy-saved').removeClass('fa fa-circle-o-notch fa-spin');
        });            
    });
  }

}]);


 // Kontak controller
app.controller('Kontak', ['$scope','$http','$location','toaster','$cookieStore','$state', function($scope,$http,$location,toaster,$cookieStore,$state) {    
  if (!$cookieStore.get('auth')) {
    $state.go('access.signin');   
  }
  $scope.path = baseurl+'gambar/sm/';
  
  
  $scope.save = function() {  
    $('#submit').addClass('disabled').removeClass('btn-addon');
    $('#load').removeClass('glyphicon glyphicon-floppy-saved').addClass('fa fa-circle-o-notch fa-spin');

    $http.post(baseurl+'admin/kontak', $scope.form)
    .then(function successCallback(response) {
      toaster.pop('success', 'Berhasil','Menambah Kontak');
      $('#submit').removeClass('disabled').addClass('btn-addon');
      $('#load').addClass('glyphicon glyphicon-floppy-saved').removeClass('fa fa-circle-o-notch fa-spin');
      $location.path('/app/setting/kontak');  
    }, function errorCallback(response) {
      toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');
      $('#submit').removeClass('disabled').addClass('btn-addon');
      $('#load').addClass('glyphicon glyphicon-floppy-saved').removeClass('fa fa-circle-o-notch fa-spin');
    });                
  }

}]);

app.controller('SemuaKontak', ['$scope','$http','$location','$modal','toaster','$timeout','$cookieStore','$state', function($scope,$http,$location,$modal,toaster,$timeout,$cookieStore,$state) {    
  if (!$cookieStore.get('auth')) {
    $state.go('access.signin');   
  }
  $scope.gambar = baseurl+'gambar/';  
  $http.get(baseurl+'admin/kontak').success(function(data) {
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
      $http.delete(baseurl+'admin/kontak/'+id)
      .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menghapus Kontak');
        $http.get(baseurl+'admin/kontak').success(function(data) {
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

app.controller('KontakRubah', ['$scope','$http','$location','$stateParams','toaster','$cookieStore','$state', function($scope,$http,$location,$stateParams,toaster,$cookieStore,$state) {   
  if (!$cookieStore.get('auth')) {
    $state.go('access.signin');   
  }
  $scope.path = baseurl+'gambar/sm/';
  $scope.files = [];  
  $http.get(baseurl+'admin/kontak_rubah/'+$stateParams.id).success(function(data) {      
    $scope.form=data;     
    $scope.image_source = baseurl+'gambar/'+data.gambar; 
  });  
  $scope.save = function() {  
    $('#submit').addClass('disabled').removeClass('btn-addon');
    $('#load').removeClass('glyphicon glyphicon-floppy-saved').addClass('fa fa-circle-o-notch fa-spin');                       
    $http.put(baseurl+'admin/kontak_update/'+$stateParams.id, $scope.form)
    .then(function successCallback(response) {
      toaster.pop('success', 'Berhasil','Merubah Kontak');
      $('#submit').removeClass('disabled').addClass('btn-addon');
      $('#load').addClass('glyphicon glyphicon-floppy-saved').removeClass('fa fa-circle-o-notch fa-spin');
      $location.path('/app/setting/kontak');  
    }, function errorCallback(response) {
      toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');
      $('#submit').removeClass('disabled').addClass('btn-addon');
      $('#load').addClass('glyphicon glyphicon-floppy-saved').removeClass('fa fa-circle-o-notch fa-spin');
    });                
  }

}]);


 // Administrator controller
app.controller('SemuaAdministrator', ['$scope','$http','$location','$modal','toaster','$timeout','$cookieStore','$state', function($scope,$http,$location,$modal,toaster,$timeout,$cookieStore,$state) {
  if (!$cookieStore.get('auth')) {
    $state.go('access.signin');   
  }
  $http.get(baseurl+'admin/administrator').success(function(data) {
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
      $http.delete(baseurl+'admin/administrator/'+id)
      .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menghapus Admin');
        $http.get(baseurl+'admin/administrator').success(function(data) {
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

app.controller('Administrator', ['$scope','$http','$location','toaster','$cookieStore','$state', function($scope,$http,$location,toaster,$cookieStore,$state) {  
  if (!$cookieStore.get('auth')) {
    $state.go('access.signin');   
  }
  $scope.save = function() {
    $('#submit').addClass('disabled').removeClass('btn-addon');
    $('#load').removeClass('glyphicon glyphicon-floppy-saved').addClass('fa fa-circle-o-notch fa-spin');                       
    $http.post(baseurl+'admin/administrator', $scope.form)
    .then(function successCallback(response) {
      toaster.pop('success', 'Berhasil','Menambah Admin');
      $location.path('/app/setting/admin');  
    }, function errorCallback(response) {
      toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');
    });                
  }
}]);

app.controller('AdministratorRubah', ['$scope','$http','$location','$stateParams','toaster','$cookieStore','$state', function($scope,$http,$location,$stateParams,toaster,$cookieStore,$state) {    
    if (!$cookieStore.get('auth')) {
      $state.go('access.signin');   
    }
    $http.get(baseurl+'admin/administrator/'+$stateParams.id).success(function(data) {      
      $scope.form=data;      
    });     
    $scope.save = function() {                  
      $('#submit').addClass('disabled').removeClass('btn-addon');
      $('#load').removeClass('glyphicon glyphicon-floppy-saved').addClass('fa fa-circle-o-notch fa-spin');                                   
      $http.put(baseurl+'admin/administrator/'+$stateParams.id, $scope.form)
      .then(function successCallback(response) {        
        if (response.data.success == true) {
          toaster.pop('success', 'Berhasil','Merubah Admin');
          $('#submit').removeClass('disabled').addClass('btn-addon');
          $('#load').addClass('glyphicon glyphicon-floppy-saved').removeClass('fa fa-circle-o-notch fa-spin');
          $location.path('/app/setting/admin');
        }else{
          $('#submit').removeClass('disabled').addClass('btn-addon');
          $('#load').addClass('glyphicon glyphicon-floppy-saved').removeClass('fa fa-circle-o-notch fa-spin');
          toaster.pop('warning', 'Warning','Password Tidak Sesuai');
        }

      }, function errorCallback(response) {                    
        toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');
        $('#submit').removeClass('disabled').addClass('btn-addon');
        $('#load').addClass('glyphicon glyphicon-floppy-saved').removeClass('fa fa-circle-o-notch fa-spin');

      });        
    }
}]);
 
 // tag controller
app.controller('TagRubah', ['$scope','$http','$location','$stateParams','toaster','$cookieStore','$state', function($scope,$http,$location,$stateParams,toaster,$cookieStore,$state) {    
    if (!$cookieStore.get('auth')) {
      $state.go('access.signin');   
    }          
    $http.get(baseurl+'admin/tag/'+$stateParams.id).success(function(data) {
      $scope.row=data;      
    });     
    
    $scope.save = function() {  
                   
      $('#submit').addClass('disabled').removeClass('btn-addon');
      $('#load').removeClass('glyphicon glyphicon-floppy-saved').addClass('fa fa-circle-o-notch fa-spin');                   
      
      $http.put(baseurl+'admin/tag_update/'+$stateParams.id, $scope.row)
      .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Merubah Tag');            
        $('#submit').removeClass('disabled').addClass('btn-addon');
        $('#load').addClass('glyphicon glyphicon-floppy-saved').removeClass('fa fa-circle-o-notch fa-spin');
        $location.path('/app/setting/tag');
      }, function errorCallback(response) {                    
        toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');
        $('#submit').removeClass('disabled').addClass('btn-addon');
        $('#load').addClass('glyphicon glyphicon-floppy-saved').removeClass('fa fa-circle-o-notch fa-spin');

      });          
      
    }
  
}]);

app.controller('SemuaTag', ['$scope','$http','$location','$modal','toaster','$timeout','$cookieStore','$state', function($scope,$http,$location,$modal,toaster,$timeout,$cookieStore,$state) {    
  if (!$cookieStore.get('auth')) {
    $state.go('access.signin');   
  }
  $http.get(baseurl+'admin/all_tag').success(function(data) {    
    $scope.tag=data;  
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
      $http.delete(baseurl+'admin/tag/'+id)
      .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menghapus Tag');
        $http.get(baseurl+'admin/all_tag').success(function(data) {
          $scope.tag=data;
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


// Home Settin controller
app.controller('HomeSetting', ['$scope','$http','toaster','$modal','$cookieStore','$state', function($scope,$http,toaster,$modal,$cookieStore,$state) {
  if (!$cookieStore.get('auth')) {
    $state.go('access.signin');   
  }
  $scope.oneAtATime = true; 
  $scope.addspecial = true; 
  $scope.setting=[];

  $http.get(baseurl+'admin/home_setting').success(function(data) {      
    $scope.setting=data;         
    $scope.accordion = false;    
    if ($scope.setting.status == 1) {
      $scope.setting.status = true ;
    }else{$scope.setting.status = false; }
  });  
    
  $http.get(baseurl+'admin/all_kategori').success(function(data) {      
    $scope.pkategori=data;         
    if ($scope.pkategori.status == 1) {
      $scope.pkategori.status = true ;
    }else{$scope.pkategori.status = false; }
  });

  $scope.kategori_klik = function(status,id) {                  
    $http.put(baseurl+'admin/kategori_setting/'+id, {text :status})
    .then(function successCallback(response) {            
        toaster.pop('success', 'Berhasil','Perubahan Disimpan');
    }, function errorCallback(response) {                    
      toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');      
    });        
  }
  $scope.klik_active = function(status,id) {                  
    $http.put(baseurl+'admin/setting_active/'+id, {text :status})
    .then(function successCallback(response) {            
        toaster.pop('success', 'Berhasil','Perubahan Disimpan');
    }, function errorCallback(response) {                    
      toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');      
    });        
  }

  $scope.setting_up = function (id) {    
    $http.get(baseurl+'admin/setting_up/'+id)
    .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Posisi Pindah');        
        $http.get(baseurl+'admin/home_setting').success(function(data) {      
          $scope.setting=data;         
          
          if ($scope.setting.status == 1) {
            $scope.setting.status = true ;
          }else{$scope.setting.status = false; }
        });
    }, function errorCallback(response) {                    
      toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');      
    });
  }
  $scope.setting_down = function (id) {    
    $http.get(baseurl+'admin/setting_down/'+id)
    .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Posisi Pindah');        
        $http.get(baseurl+'admin/home_setting').success(function(data) {      
          $scope.setting=data;         
          
          if ($scope.setting.status == 1) {
            $scope.setting.status = true ;
          }else{$scope.setting.status = false; }
        });
    }, function errorCallback(response) {                    
      toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');      
    });
  }
  $scope.save = function (status,id) {    
    $http.put(baseurl+'admin/home_setting/'+id,status)
    .then(function successCallback(response) {        
        toaster.pop('success', 'Berhasil','Dirubah');                
        $http.get(baseurl+'admin/setting_special').success(function(data) {      
          $scope.special=data;    
        });
    }, function errorCallback(response) {                    
      toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');      
    });
  }

}]); 
//special offer
app.controller('SpecialOffer', ['$scope','$http','toaster','$modal','$cookieStore','$state', function($scope,$http,toaster,$modal,$cookieStore,$state) {
  if (!$cookieStore.get('auth')) {
    $state.go('access.signin');   
  }
  $scope.oneAtATime = true; 
  $scope.addspecial = true; 
  $scope.setting=[];  
  $scope.pages =[];  
  $scope.pro =[];
  $http.get(baseurl+'admin/setting_special').success(function(data) {      
    $scope.special=data;    
  });

  $http.get(baseurl+'admin/all_kategori').success(function(data) {      
    $scope.pkategori=data;         
    if ($scope.pkategori.status == 1) {
      $scope.pkategori.status = true ;
    }else{$scope.pkategori.status = false; }
  });

  $http.get(baseurl+'admin/get_kategori_produk').success(function(data) {      
    $scope.list_kategori=data.product;
  });

  $http.get(baseurl+'admin/all_page').success(function(data) {      
    $scope.page=data;  
  });  

  $scope.klik_page = function () { 
    $http.post(baseurl+'admin/spesial_produk_page', {text : $scope.pages.id})
    .then(function successCallback(response) {        
        $scope.pages.id='';
        if (response.data.success == true) {
          toaster.pop('success', 'Berhasil','Page Spesial Di Tambah');
          $http.get(baseurl+'admin/setting_special').success(function(data) {      
            $scope.special=data;    
          });                        
        }
        if (response.data.warning == true) {
          toaster.pop('warning', 'Perhatian','Page Yang Sudah Di Tambah Tidak Akan Di Masukan');
        }     
    }, function errorCallback(response) {                    
      toaster.pop('error', 'Gagal','Harap Periksa Data Anda!');      
    });
  }
  $scope.spesial = function (id) {    
    $http.post(baseurl+'admin/spesial_produk',{text: $scope.pro.text[id]})
    .then(function successCallback(response) {
        $scope.pro.text[id]=false;
        $http.get(baseurl+'admin/setting_special').success(function(data) {      
          $scope.special=data;    
        });                        
        toaster.pop('success', 'Berhasil','Paket Tour Spesial Di Tambah');
        if (response.data.warning == true) {
          toaster.pop('warning', 'Perhatian','Paket Tour Yang Sudah Di Tambah Tidak Akan Di Masukan');
        }
    }, function errorCallback(response) {                    
      toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');      
    });
  }
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
      $http.delete(baseurl+'admin/special_hapus/'+id)
      .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menghapus Special Produk');        
        $http.get(baseurl+'admin/setting_special').success(function(data) {      
          $scope.special=data;    
        });
      }, function errorCallback(response) {                    
        toaster.pop('error', 'Gagal','Gagal Menghapus!');        
      });   

    }, function () {
      toaster.pop('warning', 'Batal','Batal Menghapus');  
    });
  }; 

}]); 

//slider
app.controller('FileUploadCtrl', ['$scope', 'FileUploader','toaster','$http','$timeout','$modal','$cookieStore','$state', function($scope, FileUploader,toaster,$http,$timeout,$modal,$cookieStore,$state) {        
  if (!$cookieStore.get('auth')) {
    $state.go('access.signin');   
  }
  $scope.path = baseurl+'galeri/'; 
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

  $http.get(baseurl+'admin/slider').success(function(data) {
    $scope.dataset=data;
    $timeout(function(){
        $('.table').trigger('footable_redraw').trigger('footable_resize').trigger('footable_initialized');        
    }, 100); 
  }); 
  // CALLBACKS
 
  uploader.onCompleteItem = function(fileItem, response, status, headers) {        
      $http.post(baseurl+'admin/slider_baru', {text:fileItem.file.name})
      .then(function successCallback(response) {          
      }, function errorCallback(response) {                    
        toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');
      }); 
      console.info(fileItem.file.name);
  };
  uploader.onCompleteAll = function() {
      toaster.pop('success', 'Berhasil','Mengupload Semua Slider');
      uploader.clearQueue();
      $http.get(baseurl+'admin/slider').success(function(data) {
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
      $http.delete(baseurl+'admin/slider_hapus/'+id)
      .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menghapus Slider');        
        $http.get(baseurl+'admin/slider').success(function(data) {
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

app.controller('SliderRubah', ['$scope','$http','$location','$stateParams','toaster','$cookieStore','$state', function($scope,$http,$location,$stateParams,toaster,$cookieStore,$state) {    
    if (!$cookieStore.get('auth')) {
      $state.go('access.signin');   
    }   
    $http.get(baseurl+'admin/slider/'+$stateParams.id).success(function(data) {
      $scope.row=data;      
    });     
    
    $scope.save = function() {  
                   
      $('#submit').addClass('disabled').removeClass('btn-addon');
      $('#load').removeClass('glyphicon glyphicon-floppy-saved').addClass('fa fa-circle-o-notch fa-spin');                   
      
      $http.put(baseurl+'admin/slider/'+$stateParams.id, $scope.row)
      .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Merubah Slider');            
        $('#submit').removeClass('disabled').addClass('btn-addon');
        $('#load').addClass('glyphicon glyphicon-floppy-saved').removeClass('fa fa-circle-o-notch fa-spin');
        console.log($scope.row);
        $location.path('/app/setting/semua_slider');
      }, function errorCallback(response) {                    
        toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');
        $('#submit').removeClass('disabled').addClass('btn-addon');
        $('#load').addClass('glyphicon glyphicon-floppy-saved').removeClass('fa fa-circle-o-notch fa-spin');

      });          
      
    }  
}]);

// Menu controller
app.controller('Menu', ['$scope','$http','toaster','$modal','$cookieStore','$state', function($scope,$http,toaster,$modal,$cookieStore,$state) {
  if (!$cookieStore.get('auth')) {
    $state.go('access.signin');   
  }
  $scope.oneAtATime = true;
  $scope.form =[];
  $scope.pages =[];
  $scope.kategoris =[];
  $scope.custom =[]
  $scope.home =[];
  $scope.blogs =[];
  $scope.kontaks =[];
  $scope.bookings =[];  
  
  $scope.home.judul = 'home';
  $scope.pages.judul = 'page';
  $scope.kategoris.judul = 'kategori';  
  $scope.blogs.judul = 'blog';
  $scope.kontaks.judul = 'contact';
  $scope.bookings.judul = 'booking';

  $scope.home.link = baseurl;
  $scope.blogs.link = baseurl+'blog.html';
  $scope.kontaks.link = baseurl+'contact.html';
  $scope.bookings.link = baseurl+'booking.html';

  $http.get(baseurl+'admin/all_page').success(function(data) {      
    $scope.page=data;  
  });
  $http.get(baseurl+'admin/all_kategori').success(function(data) {      
    $scope.pkategori=data;  
  });

  $http.get(baseurl+'admin/menu').success(function(data) {          
    $scope.menu=data;
    $scope.accordion = false;
  });

  $scope.klik_page = function () {        
    $http.post(baseurl+'admin/menu', {judul : $scope.pages.judul,link : $scope.pages.link})
    .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menu Di tambah');
        $scope.pages.link ='';
        $http.get(baseurl+'admin/menu').success(function(data) {      
          $scope.menu=data;  
        });        
    }, function errorCallback(response) {                    
      toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');      
    });
  }
  $scope.klik_kategori = function () {    
    $http.post(baseurl+'admin/menu', {judul : $scope.kategoris.judul,link : $scope.kategoris.link})
    .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menu Di tambah');
        $scope.kategoris.link ='';
        $http.get(baseurl+'admin/menu').success(function(data) {      
          $scope.menu=data;  
        });        
    }, function errorCallback(response) {                    
      toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');      
    });
  }
  $scope.klik_custom_link = function () {    
    $http.post(baseurl+'admin/menu', {judul : $scope.custom.judul,link : $scope.custom.link})
    .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menu Di tambah');
        $scope.custom =[];
        $http.get(baseurl+'admin/menu').success(function(data) {      
          $scope.menu=data;  
        });        
    }, function errorCallback(response) {                    
      toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');      
    });
  }
  $scope.klik_blog = function () {    
    $http.post(baseurl+'admin/menu', {judul : $scope.blogs.judul,link : $scope.blogs.link})
    .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menu Di tambah');        
        $http.get(baseurl+'admin/menu').success(function(data) {      
          $scope.menu=data;  
        });        
    }, function errorCallback(response) {                    
      toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');      
    });
  }
  $scope.klik_kontak = function () {    
    $http.post(baseurl+'admin/menu', {judul : $scope.kontaks.judul,link : $scope.kontaks.link})
    .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menu Di tambah');        
        $http.get(baseurl+'admin/menu').success(function(data) {      
          $scope.menu=data;  
        });        
    }, function errorCallback(response) {                    
      toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');      
    });
  }
  $scope.klik_booking = function () {    
    $http.post(baseurl+'admin/menu', {judul : $scope.bookings.judul,link : $scope.bookings.link})
    .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menu Di tambah');        
        $http.get(baseurl+'admin/menu').success(function(data) {      
          $scope.menu=data;  
        });        
    }, function errorCallback(response) {                    
      toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');      
    });
  }
  $scope.klik_home = function () {    
    $http.post(baseurl+'admin/menu', {judul : $scope.home.judul,link : $scope.home.link})
    .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menu Di tambah');        
        $http.get(baseurl+'admin/menu').success(function(data) {      
          $scope.menu=data;  
        });        
    }, function errorCallback(response) {                    
      toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');      
    });
  }
  ///
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
      $http.delete(baseurl+'admin/menu/'+id)
      .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menghapus Menu');                
        $http.get(baseurl+'admin/menu').success(function(data) {      
          $scope.menu=data;  
        });        
      }, function errorCallback(response) {                    
        toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');                
      });   

    }, function () {
      toaster.pop('warning', 'Batal','Batal Menghapus');  
    });
  };

  $scope.menu_up = function (id) {    
    $http.get(baseurl+'admin/menu_up/'+id)
    .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menu Pindah');        
        $http.get(baseurl+'admin/menu').success(function(data) {      
          $scope.menu=data;  
        });        
    }, function errorCallback(response) {                    
      toaster.pop('warning', 'Gagal','Tidak Datap Dipindahkan!');      
    });
  }
  $scope.menu_down = function (id) {    
    $http.get(baseurl+'admin/menu_down/'+id)
    .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menu Pindah');        
        $http.get(baseurl+'admin/menu').success(function(data) {      
          $scope.menu=data;  
        });
    }, function errorCallback(response) {                    
      toaster.pop('warning', 'Gagal','Tidak Datap Dipindahkan!');      
    });
  }
  
  $scope.save = function (status,id) {    
    $http.put(baseurl+'admin/menu/'+id,status)
    .then(function successCallback(response) {        
        toaster.pop('success', 'Berhasil','Dirubah');                
        $http.get(baseurl+'admin/menu').success(function(data) {          
          $scope.menu=data;
          $scope.accordion = false;
        });
    }, function errorCallback(response) {                    
      toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');      
    });
  }

}]); 
app.controller('MenuTambahan', ['$scope','$http','toaster','$modal','$cookieStore','$state', function($scope,$http,toaster,$modal,$cookieStore,$state) {
  if (!$cookieStore.get('auth')) {
    $state.go('access.signin');   
  }
  $scope.oneAtATime = true;
  $scope.form = [];
  $scope.list_kolom = [
    {judul:'Sosial Media',role:1},
    {judul:'Kontak',role:2},
    {judul:'Logo',role:3},
    {judul:'Deskripsi',role:4},    
    {judul:'Semua Kategori',role:5},
    {judul:'Profil Website',role:6},
    {judul:'Special Offer',role:7},
    {judul:'Menu',role:8}
  ];
  $scope.custom =[]
    
  $scope.blog =[];
  $scope.blog.judul = 'blog';
  $scope.blog.link = baseurl+'blog.html'; 

  $scope.sitemap =[];
  $scope.sitemap.judul = 'sitemap';
  $scope.sitemap.link = baseurl+'sitemap.xml';

  $scope.galeri =[];
  $scope.galeri.judul = 'galeri';
  $scope.galeri.link = baseurl+'gallery.html';

  $http.get(baseurl+'admin/menu_footer').success(function(data) {      
    $scope.menu_footer=data;  
  });
  $http.get(baseurl+'admin/all_galeri_kategori').success(function(data) {      
    $scope.all_galeri_kategori=data;  
  });
  
  $scope.klik_footer = function () {       
    $http.post(baseurl+'admin/footer', {role : $scope.form.role,posisi : $scope.form.posisi})
    .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menu Di tambah');
        $http.get(baseurl+'admin/footer/'+$scope.form.posisi).success(function(data) {      
          if ($scope.form.posisi == 1) {
            $scope.footer_kolom1=data;
          }if($scope.form.posisi == 2){
            $scope.footer_kolom2=data;
          }if($scope.form.posisi == 3){
            $scope.footer_kolom3=data;
          }
        });
    }, function errorCallback(response) {                    
      toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');      
    });
  }
  $scope.klik_footer_slider = function () {       
    $http.post(baseurl+'admin/footer', {role : 9,posisi : $scope.galeri.posisi,id_galeri_kategori :$scope.galeri.galeri_kategori })
    .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menu Di tambah');
        $http.get(baseurl+'admin/footer/'+$scope.galeri.posisi).success(function(data) {      
          if ($scope.galeri.posisi == 1) {
            $scope.footer_kolom1=data;
          }if($scope.galeri.posisi == 2){
            $scope.footer_kolom2=data;
          }if($scope.galeri.posisi == 3){
            $scope.footer_kolom3=data;
          }
        });
    }, function errorCallback(response) {                    
      toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');      
    });
  }
  $scope.klik_kategori = function () {    
    $http.post(baseurl+'admin/menu', {judul : $scope.kategoris.judul,link : $scope.kategoris.link})
    .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menu Di tambah');
        $scope.kategoris.link ='';
        $http.get(baseurl+'admin/menu').success(function(data) {      
          $scope.menu=data;  
        });
        
    }, function errorCallback(response) {                    
      toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');      
    });
  }  

  $scope.klik_sitemap = function () {    
    $http.post(baseurl+'admin/menu_footer', {judul : $scope.sitemap.judul,link : $scope.sitemap.link})
    .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menu Tambahan Di Tambah');                
        $http.get(baseurl+'admin/menu_footer').success(function(data) {      
          $scope.menu_footer=data;  
        });
    }, function errorCallback(response) {                    
      toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');      
    });
  }
  $scope.klik_galeri = function () {    
    $http.post(baseurl+'admin/menu_footer', {judul : $scope.galeri.judul,link : $scope.galeri.link})
    .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menu Tambahan Di Tambah');
        $http.get(baseurl+'admin/menu_footer').success(function(data) {      
          $scope.menu_footer=data;  
        });
    }, function errorCallback(response) {                    
      toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');      
    });
  }  
  $scope.klik_custom_link = function () {    
    $http.post(baseurl+'admin/menu_footer', {judul : $scope.custom.judul,link : $scope.custom.link})
    .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menu_footer Di tambah');
        $scope.custom =[];        
        $http.get(baseurl+'admin/menu_footer').success(function(data) {      
          $scope.menu_footer=data;  
        });
    }, function errorCallback(response) {                    
      toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');      
    });
  }
  $scope.klik_blog = function () {    
    $http.post(baseurl+'admin/menu_footer', {judul : $scope.blog.judul,link : $scope.blog.link})
    .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menu Tambahan Di tambah');                
        $http.get(baseurl+'admin/menu_footer').success(function(data) {      
          $scope.menu_footer=data;  
        });
    }, function errorCallback(response) {                    
      toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');      
    });
  }  
  
  ///
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
      $http.delete(baseurl+'admin/menu_footer/'+id)
      .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menghapus Menu Footer');                
        $http.get(baseurl+'admin/menu_footer').success(function(data) {      
          $scope.menu_footer=data;  
        });
      }, function errorCallback(response) {                    
        toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');                
      });   

    }, function () {
      toaster.pop('warning', 'Batal','Batal Menghapus');  
    });
  };

  $scope.edit = function (id) {
    $http.get(baseurl+'admin/menu_footer/'+id).success(function(data) {      
      $scope.get_menu_footer=data;          
      var modalInstance = $modal.open({
        templateUrl: 'modal_menu_footer.html',
        controller: 'modal_menu_footer',      
        resolve: {
          items: function () {
            return $scope.get_menu_footer;
          }
        }
      });
      modalInstance.result.then(function (response){
        
        $http.put(baseurl+'admin/menu_footer/'+id, response)
        .then(function successCallback(response) {
          toaster.pop('success', 'Berhasil','Merubah Menu Footer');
          $http.get(baseurl+'admin/menu_footer').success(function(data) {      
            $scope.menu_footer=data;  
          });
        }, function errorCallback(response) {
          toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!')
        });    

      }, function () {
          
      });
    });    
  };

  ///

  $scope.footer_delete = function (posisi,id) {
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
      $http.delete(baseurl+'admin/footer/'+id)
      .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menghapus Footer');                
        $http.get(baseurl+'admin/footer/'+posisi).success(function(data) {      
          if (posisi == 1) {
            $scope.footer_kolom1=data;
          }if(posisi == 2){
            $scope.footer_kolom2=data;
          }if(posisi == 3){
            $scope.footer_kolom3=data;
          }

        });
      }, function errorCallback(response) {                    
        toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');                
      });   

    }, function () {
      toaster.pop('warning', 'Batal','Batal Menghapus');  
    });
  };

  $scope.footer_edit = function (posisi,id) {
    $http.get(baseurl+'admin/get_footer/'+id).success(function(data) {      
      $scope.get_footer=data;          
      var modalInstance = $modal.open({
        templateUrl: 'modal_footer.html',
        controller: 'modal_menu_footer',      
        resolve: {
          items: function () {
            return $scope.get_footer;
          }
        }
      });
      modalInstance.result.then(function (response){
        
        $http.put(baseurl+'admin/footer/'+id, response)
        .then(function successCallback(response) {
          toaster.pop('success', 'Berhasil','Merubah Footer');
          $http.get(baseurl+'admin/footer/'+posisi).success(function(data) {      
            if (posisi == 1) {
              $scope.footer_kolom1=data;
            }if(posisi == 2){
              $scope.footer_kolom2=data;
            }if(posisi == 3){
              $scope.footer_kolom3=data;
            }
          });
        }, function errorCallback(response) {
          toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!')
        });    

      }, function () {
          
      });
    });    
  };

}]); 

app.controller('Footer', ['$scope','$http','toaster','$modal','$cookieStore','$state','$timeout', function($scope,$http,toaster,$modal,$cookieStore,$state,$timeout) {
  if (!$cookieStore.get('auth')) {
    $state.go('access.signin');   
  }
  $scope.status = {};
  $scope.status.kolom1 = true;
  $scope.status.kolom2 = true;
  $scope.status.kolom3 = true;

  $scope.oneAtATime = false;
  $scope.oneAtATimes = true;
  $scope.form = [];
  $scope.list_kolom = [
    {judul:'Sosial Media',role:1},
    {judul:'Kontak',role:2},
    {judul:'Logo',role:3},
    {judul:'Deskripsi',role:4},    
    {judul:'Semua Kategori',role:5},
    {judul:'Profil Website',role:6},
    {judul:'Special Offer',role:7},
    {judul:'Menu',role:8},
    {judul:'Map',role:11}
  ];
  $scope.custom =[]
    
  $scope.blog =[];
  $scope.blog.judul = 'blog';
  $scope.blog.link = baseurl+'blog'; 

  $scope.sitemap =[];
  $scope.sitemap.judul = 'sitemap';
  $scope.sitemap.link = baseurl+'sitemap.xml';

  $scope.galeri =[];
  $scope.kategori =[];
  $scope.galeri.judul = 'galeri';
  $scope.galeri.link = baseurl+'gallery';

  $http.get(baseurl+'admin/menu_footer').success(function(data) {      
    $scope.menu_footer=data;  
  });
  $http.get(baseurl+'admin/all_galeri_kategori').success(function(data) {      
    $scope.all_galeri_kategori=data;  
  });
  $http.get(baseurl+'admin/footer/'+1).success(function(data) {      
    $scope.footer_kolom1=data;  
  });
  $http.get(baseurl+'admin/footer/'+2).success(function(data) {      
    $scope.footer_kolom2=data;  
  });
  $http.get(baseurl+'admin/footer/'+3).success(function(data) {      
    $scope.footer_kolom3=data;  
  });
  $http.get(baseurl+'admin/all_kategori').success(function(data) {
      $scope.kategori_paket_tour=data;    
    }); 
  $scope.klik_footer = function () {       
    $http.post(baseurl+'admin/footer', {role : $scope.form.role,posisi : $scope.form.posisi})
    .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menu Di tambah');        
        $http.get(baseurl+'admin/footer/'+$scope.form.posisi).success(function(data) {      
          if ($scope.form.posisi == 1) {
            $scope.footer_kolom1=data;
          }if($scope.form.posisi == 2){
            $scope.footer_kolom2=data;
          }if($scope.form.posisi == 3){
            $scope.footer_kolom3=data;
          }
          $timeout(function(){
            $scope.form =[];
          }, 100); 
        });
    }, function errorCallback(response) {                    
      toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');      
    });
  }
  $scope.klik_paket_tour = function () {       
    $http.post(baseurl+'admin/footer', {role : 10,posisi : $scope.kategori.posisi,id_galeri_kategori :$scope.kategori.paket_tour_kategori })
    .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menu Di tambah');
        $scope.kategori =[];
        $http.get(baseurl+'admin/footer/'+$scope.kategori.posisi).success(function(data) {      
          if ($scope.kategori.posisi == 1) {
            $scope.footer_kolom1=data;
          }if($scope.kategori.posisi == 2){
            $scope.footer_kolom2=data;
          }if($scope.kategori.posisi == 3){
            $scope.footer_kolom3=data;
          }
        });
    }, function errorCallback(response) {                    
      toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');      
    });
  }
  $scope.klik_footer_slider = function () {       
    $http.post(baseurl+'admin/footer', {role : 9,posisi : $scope.galeri.posisi,id_galeri_kategori :$scope.galeri.galeri_kategori })
    .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menu Di tambah');        
        $http.get(baseurl+'admin/footer/'+$scope.galeri.posisi).success(function(data) {                
          if ($scope.galeri.posisi == 1) {
            $scope.footer_kolom1=data;
          }if($scope.galeri.posisi == 2){
            $scope.footer_kolom2=data;
          }if($scope.galeri.posisi == 3){
            $scope.footer_kolom3=data;
          }
          $timeout(function(){
            $scope.form =[];
          }, 100);
        });
    }, function errorCallback(response) {                    
      toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');      
    });
  }
  $scope.klik_kategori = function () {    
    $http.post(baseurl+'admin/menu', {judul : $scope.kategoris.judul,link : $scope.kategoris.link})
    .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menu Di tambah');
        $scope.kategoris.link ='';
        $http.get(baseurl+'admin/menu').success(function(data) {      
          $scope.menu=data;  
        });
        
    }, function errorCallback(response) {                    
      toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');      
    });
  }  

  $scope.klik_sitemap = function () {    
    $http.post(baseurl+'admin/menu_footer', {judul : $scope.sitemap.judul,link : $scope.sitemap.link})
    .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menu Footer Di Tambah');                
        $http.get(baseurl+'admin/menu_footer').success(function(data) {      
          $scope.menu_footer=data;  
        });
    }, function errorCallback(response) {                    
      toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');      
    });
  }
  $scope.klik_galeri = function () {    
    $http.post(baseurl+'admin/menu_footer', {judul : $scope.galeri.judul,link : $scope.galeri.link})
    .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menu Footer Di Tambah');
        $http.get(baseurl+'admin/menu_footer').success(function(data) {      
          $scope.menu_footer=data;  
        });
    }, function errorCallback(response) {                    
      toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');      
    });
  }  
  $scope.klik_custom_link = function () {    
    $http.post(baseurl+'admin/menu_footer', {judul : $scope.custom.judul,link : $scope.custom.link})
    .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menu_footer Di tambah');
        $scope.custom =[];        
        $http.get(baseurl+'admin/menu_footer').success(function(data) {      
          $scope.menu_footer=data;  
        });
    }, function errorCallback(response) {                    
      toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');      
    });
  }
  $scope.klik_blog = function () {    
    $http.post(baseurl+'admin/menu_footer', {judul : $scope.blog.judul,link : $scope.blog.link})
    .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menu Footer Di tambah');                
        $http.get(baseurl+'admin/menu_footer').success(function(data) {      
          $scope.menu_footer=data;  
        });
    }, function errorCallback(response) {                    
      toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');      
    });
  }  
  
  ///
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
      $http.delete(baseurl+'admin/menu_footer/'+id)
      .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menghapus Menu Footer');                
        $http.get(baseurl+'admin/menu_footer').success(function(data) {      
          $scope.menu_footer=data;  
        });
      }, function errorCallback(response) {                    
        toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');                
      });   

    }, function () {
      toaster.pop('warning', 'Batal','Batal Menghapus');  
    });
  };

  $scope.edit = function (id) {
    $http.get(baseurl+'admin/menu_footer/'+id).success(function(data) {      
      $scope.get_menu_footer=data;          
      var modalInstance = $modal.open({
        templateUrl: 'modal_menu_footer.html',
        controller: 'modal_menu_footer',      
        resolve: {
          items: function () {
            return $scope.get_menu_footer;
          }
        }
      });
      modalInstance.result.then(function (response){
        
        $http.put(baseurl+'admin/menu_footer/'+id, response)
        .then(function successCallback(response) {
          toaster.pop('success', 'Berhasil','Merubah Menu Footer');
          $http.get(baseurl+'admin/menu_footer').success(function(data) {      
            $scope.menu_footer=data;  
          });
        }, function errorCallback(response) {
          toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!')
        });    

      }, function () {
          
      });
    });    
  };

  ///

  $scope.footer_delete = function (posisi,id) {
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
      $http.delete(baseurl+'admin/footer/'+id)
      .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menghapus Footer');                
        $http.get(baseurl+'admin/footer/'+posisi).success(function(data) {      
          if (posisi == 1) {
            $scope.footer_kolom1=data;
          }if(posisi == 2){
            $scope.footer_kolom2=data;
          }if(posisi == 3){
            $scope.footer_kolom3=data;
          }

        });
      }, function errorCallback(response) {                    
        toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!');                
      });   

    }, function () {
      toaster.pop('warning', 'Batal','Batal Menghapus');  
    });
  };

  $scope.footer_edit = function (posisi,id) {
    $http.get(baseurl+'admin/get_footer/'+id).success(function(data) {      
      $scope.get_footer=data;          
      var modalInstance = $modal.open({
        templateUrl: 'modal_footer.html',
        controller: 'modal_menu_footer',      
        resolve: {
          items: function () {
            return $scope.get_footer;
          }
        }
      });
      modalInstance.result.then(function (response){
        
        $http.put(baseurl+'admin/footer/'+id, response)
        .then(function successCallback(response) {
          toaster.pop('success', 'Berhasil','Merubah Footer');
          $http.get(baseurl+'admin/footer/'+posisi).success(function(data) {      
            if (posisi == 1) {
              $scope.footer_kolom1=data;
            }if(posisi == 2){
              $scope.footer_kolom2=data;
            }if(posisi == 3){
              $scope.footer_kolom3=data;
            }
          });
        }, function errorCallback(response) {
          toaster.pop('error', 'Gagal','Harap Periksa Koneksi Anda!')
        });    

      }, function () {
          
      });
    });    
  };

}]); 

app.controller('modal_menu_footer', ['$scope', '$modalInstance', 'items', function($scope, $modalInstance, items) {
  $scope.items = items;
  $scope.ok = function () {    
    $modalInstance.close($scope.items);
  };

  $scope.cancel = function () {
    $modalInstance.dismiss('cancel');
  };
}]); 

