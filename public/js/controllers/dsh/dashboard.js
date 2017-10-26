'use strict';

/* Controllers */

app.controller('Dashboard', ['$scope','$http','$modal', '$log','$timeout','toaster','$cookieStore','$state', function($scope,$http, $modal, $log,$timeout,toaster,$cookieStore,$state) {
  
  if (!$cookieStore.get('auth')) {
    $state.go('access.signin');   
  }
  
  $http.get(baseurl+'admin/booking').success(function(data) {
    $scope.dataset=data;
    $timeout(function(){
      $('.table').trigger('footable_redraw').trigger('footable_resize').trigger('footable_initialized');        
    }, 100);   
  });

  $scope.items = ['item1', 'item2', 'item3'];
  

  $scope.open = function (id) {
    $http.get(baseurl+'admin/booking/'+id).success(function(data) {
      $scope.items=data;    
      var modalInstance = $modal.open({
        templateUrl: 'myModalContent.html',
        controller: 'ModalInstanceCtrl',      
        resolve: {
          items: function () {
            return $scope.items;
          }
        }
      });

      modalInstance.result.then(function (selectedItem) {
        var modalInstanc = $modal.open({
          templateUrl: 'hapus.html',
          controller: 'Hapus',      
          resolve: {
            items: function () {
              return $scope.items;
            }
          }
        });
        modalInstanc.result.then(function () {      
                  
            $http.delete(baseurl+'admin/booking/'+$scope.items['single'].id)
            .then(function successCallback(response) {
              toaster.pop('success', 'Berhasil','Menghapus Boking');
              $http.get(baseurl+'admin/booking').success(function(data) {
                $scope.dataset=data;
                $timeout(function(){
                  $('.table').trigger('footable_redraw').trigger('footable_resize').trigger('footable_initialized');        
                }, 100);   
              });
            }, function errorCallback(response) {                    
              toaster.pop('error', 'Gagal','Ada Kesalahan!');        
            });

        }, function () {
          toaster.pop('warning', 'Batal','Batal Menghapus');  
        });
      }, function () {      

      });

    });    
  };

}]); 

app.controller('ModalInstanceCtrl', ['$scope', '$modalInstance', 'items', function($scope, $modalInstance, items) {
  $scope.items = items;
  $scope.ok = function () {
    $modalInstance.close();
  };

  $scope.cancel = function () {
    $modalInstance.dismiss('cancel');
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
