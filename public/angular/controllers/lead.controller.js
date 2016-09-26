'use strict';

angular.module('lead').controller('LeadController', ['$scope','$http', '$stateParams', 'Buyer', 'Seller', 'Vendor', 'Contact',  
	function($scope, $http, $stateParams, Buyer, Seller, Vendor, Contact) {
		$scope.keyword = '';
		$scope.searchType = 'buyer';
		$scope.leads = [];
		$scope.lead = {};		
		$scope.totalBuyer = {};
		$scope.$stateParams = $stateParams;

		$scope.find = function() {
			switch($scope.searchType){
				case 'seller' : $state.go('lead.seller', { keyword: $scope.keyword });
				case 'vendor' : $state.go('lead.vendor', { keyword: $scope.keyword });
				case 'contact' : $state.go('lead.contact', { keyword: $scope.keyword });
				default : $state.go('lead.buyer', { keyword: $scope.keyword });
			}
		};

		$scope.findOne = function () {
			if ($stateParams.type === 'Buyer') $scope.lead = Buyer.get({ id: $stateParams.id });
			else if ($stateParams.type === 'Seller') $scope.lead = Seller.get({ id: $stateParams.id });
			else if ($stateParams.type === 'Vendor') $scope.lead = Vendor.get({ id: $stateParams.id });
			else if ($stateParams.type === 'Contact') $scope.lead = Contact.get({ id: $stateParams.id });
		
		};
		
		$scope.total = function () {
			$scope.totalBuyer = Buyer.get({action : 'total'});									
			$scope.totalSeller = Seller.get({action : 'total'});
			$scope.totalVendor = Vendor.get({action : 'total'});
			$scope.totalContact = Contact.get({action : 'total'});
		};
}]);
