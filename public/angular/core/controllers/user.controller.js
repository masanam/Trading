'use strict';

angular.module('user').controller('UserController', ['$scope', '$http', '$stateParams', '$state', 'User', 'Authentication', 'S3Upload',
  function($scope, $http, $stateParams, $state, User, Authentication, S3Upload) {
    $scope.user = {};
    $scope.password = '';
    $scope.cpassword = '';

    $scope.selectImage = function(files) {
      if (files) {
        var filename = Math.random().toString(16).substring(7) + files.name.substring(files.name.lastIndexOf('.'));
        var folder = 'profile-img';

        S3Upload.upload(files, filename, folder, function(err, data, config){
          //kalo error, alert pesan errornya
          if(err) return alert(err);

          //kalo sukses, ubah database nama file nya
          var fileUrl = config.url + '/' + folder + '/' + filename;
          var profile = new User(Authentication.user);
          profile.image = fileUrl;
          
          profile.$update({ id: profile.id }, function () {
            $scope.user.image = Authentication.user.image = fileUrl;
          }, function (errorResponse) {
            $scope.error = errorResponse.data.message;
          });
        });
      }
    };

    $scope.update = function() {
      $scope.loading = true;
      
      if($scope.user.password === $scope.user.cpassword){
        
        $scope.user.$update({ id: $scope.user.id }, function(response) {
          $state.go('user.index');
          $scope.loading = false;
        });
      } else {
        alert('Password does not match!');
      }
      
    };

    $scope.resetPassword = function() {
      if($scope.user.password === $scope.user.confirmPassword){
        $scope.loading = true;

        $scope.user.$update({ option: 'reset-password', id: $scope.user.id }, function(response) {
          $state.go('user.index');
          $scope.loading = false;
        });
      } else {
        alert('Password does not match!');
      }
    };

    // $scope.forgotPassword = function() {
    //   var user = new User({
    //     'email': $scope.user.email
    //   });
    //   user.$save({ action: 'password' , email: 'email' }, function(response) {
    //     console.log(response);
    //   });
    // };

    $scope.findOne = function() {
      $scope.userId = Authentication.user.id;
      $scope.user = User.get({ id: $scope.userId });
    };
  }
]);