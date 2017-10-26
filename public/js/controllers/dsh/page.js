'use strict';

/* Controllers */
app.controller('Page', ['$scope','$http','$cookieStore','$state','$location','toaster', function($scope,$http,$cookieStore,$state,$location,toaster) {    
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
          
          $http.post(baseurl+'admin/page_baru', $scope.form)
          .then(function successCallback(response) {
            toaster.pop('success', 'Berhasil','Membuat Page');
            $('#submit').removeClass('disabled').addClass('btn-addon');
            $('#load').addClass('glyphicon glyphicon-floppy-saved').removeClass('fa fa-circle-o-notch fa-spin');
            $location.path('/app/page/semua_page');
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

app.controller('PageRubah', ['$scope','$http','$cookieStore','$state','$location','$stateParams','toaster', function($scope,$http,$cookieStore,$state,$location,$stateParams,toaster) {    
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
  
   
    $http.get(baseurl+'admin/page/'+$stateParams.id).success(function(data) {
      $scope.image_source = baseurl+'gambar/thumb/'+data.gambar; 
      $scope.form=data;
      if (data.status == 1) {
        $scope.form.status = true ;
      }else{$scope.form.status = false; }  
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
          
          $http.put(baseurl+'admin/page_update/'+$stateParams.id, $scope.form)
          .then(function successCallback(response) {
            toaster.pop('success', 'Berhasil','Merubah Page');
            $('#submit').removeClass('disabled').addClass('btn-addon');
            $('#load').addClass('glyphicon glyphicon-floppy-saved').removeClass('fa fa-circle-o-notch fa-spin');
            $location.path('/app/page/semua_page');
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


app.controller('SemuaPage', ['$scope','$http','$cookieStore','$state','$location','$modal','toaster','$timeout', function($scope,$http,$cookieStore,$state,$location,$modal,toaster,$timeout) {    
  if (!$cookieStore.get('auth')) {
    $state.go('access.signin');   
  }
  $scope.url_link = baseurl;
  $scope.gambar = baseurl+'gambar/thumb/';  
  $http.get(baseurl+'admin/all_page').success(function(data) {
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
      $http.delete(baseurl+'admin/page/'+id)
      .then(function successCallback(response) {
        toaster.pop('success', 'Berhasil','Menghapus Page');
        $http.get(baseurl+'admin/all_page').success(function(data) {
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