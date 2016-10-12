'use strict';

angular.module('user').controller('UserController', ['$scope', '$http', '$stateParams', '$state', 'User', 'Authentication', 'S3Upload',
  function($scope, $http, $stateParams, $state, User, Authentication, S3Upload) {
    $scope.user = {};

    $scope.selectImage = function(files) {
      if (files) {
        var filename = Math.random().toString(16).substring(7) + files.name.substring(files.name.lastIndexOf('.'));
        var folder = 'profile-img';

        S3Upload.upload(files, filename, folder, function(err, data, config){
          //kalo error, alert pesan errornya
          if(err) return alert(err);

          //kalo sukses, ubah database nama file nya
          var fileUrl = config.url + '/' + folder + '/' + $scope.authentication.user.username + '/' + filename;
          var profile = new Users(Authentication.user);
          profile.image = fileUrl;
          
          profile.$update(function () {
            $scope.user.image = $scope.profile.image = Authentication.user.image = fileUrl;
          }, function (errorResponse) {
            $scope.error = errorResponse.data.message;
          });
        });
      }
    };

    $scope.update = function() {
      $scope.loading = true;

      $scope.user.$update({ id: $scope.user.id }, function(response) {
        $state.go('user.index');
        $scope.loading = false;
      });
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

    $scope.findOne = function() {
      $scope.userId = Authentication.user.id;
      $scope.user = User.get({ id: $scope.userId });
    }
  }
]);