'use strict';

angular.module('user', ['datatables']).controller('UserController', ['$scope', '$http', '$stateParams', '$state', 'User', 'Authentication',
	function($scope, $http, $stateParams, $state, User, Authentication) {
		$scope.user = {};

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
}]);