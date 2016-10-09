angular.module('index').controller('LayoutController', ['$scope',  
	function($scope) {
		$scope.openSidebar = function () {
			$scope.collapse = !$scope.collapse;
		};
	}
]);