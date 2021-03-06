'use strict';

angular.module('user').controller('UserController', ['$scope', '$http', '$stateParams', '$state', 'User', 'Authentication', 'Role', 'S3Upload',
  function($scope, $http, $stateParams, $state, User, Authentication, Role, S3Upload) {
    $scope.selectedRoles = [];
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

      if ($scope.user.password && !$scope.user.old_password) {
        $scope.success = undefined;
        $scope.error = 'Enter old password if you want to change password!';
      }

      else if($scope.user.password === $scope.user.cpassword){

        $scope.user.$update({ id: $scope.user.id }, function(response) {
          //$state.go('user.index');
          $scope.loading = false;
          $scope.error = undefined;
          if(response.message){
            $scope.error = response.message;
          }else{
            $scope.success = 'Your profile has been updated successfully';
          }
        }, function(response){
          $scope.error = response.data.message;
        });
      } else {
        delete $scope.user.password;
        delete $scope.user.cpassword;
        delete $scope.user.old_password;
        $scope.success = undefined;
        $scope.error = 'Password does not match!';
      }
    };

    $scope.updateRole = function(roles) {
      var user = new User({
        roles: roles
      });

      user.$update({ id: Authentication.user.id }, function(res) {
        console.log(res);
        Authentication = $scope.Authentication = {};
        $state.go('auth.signin', {});
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

    $scope.forgotPassword = function() {
      var user = new User({
        'email': $scope.user.email
      });
      console.log(user);
      user.$save({ action: 'password' , actionDetail: 'email' }, function(response) {
        console.log(response);
      });
    };

    $scope.findOne = function() {
      $scope.userId = Authentication.user.id;
      $scope.user = User.get({ id: $scope.userId });
    };
  }
]);
