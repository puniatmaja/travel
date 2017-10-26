'use strict';

/* Controllers */
  // signin controller
app.controller('SigninFormController', ['$scope', '$http', '$state','$cookieStore', function($scope, $http, $state,$cookieStore) {
    $cookieStore.remove('auth');
    $scope.user = {};
    $scope.authError = null;
    $scope.success = null;
     $scope.logo = baseurl+'img/logo.png';    
    $scope.login = function() {
      $scope.success = null;
      $scope.authError = null;
      // Try to login
      $http.post(baseurl+'admin/auth', {username: $scope.user.username, password: $scope.user.password})
      .then(function(response) {                
        
        if (response.data.success == 'true') {
          $cookieStore.put('auth',response.data);
          $scope.success = 'Login Berhasil';                   
          $state.go('app.dashboard');
        }else{
          $scope.authError = response.data.error;
        }
      }, function(x) {
        $scope.authError = response.data.error;
      });
    };
}]);

app.controller('LogoutController', ['$scope','$state','$cookieStore', function($scope,$state,$cookieStore) { 
  $cookieStore.remove('auth');
  $state.go('app.dashboard');
}]);