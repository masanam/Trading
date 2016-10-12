angular.module('index').controller('LayoutController', ['$scope', 'Authentication',
	function($scope, Authentication) {
		$scope.Authentication = Authentication;
		
		$scope.openSidebar = function () {
			$scope.collapse = !$scope.collapse;
		};
	}
]);