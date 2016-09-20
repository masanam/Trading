'use strict';

angular.module('lead').controller('LeadController', ['$scope','$http', '$stateParams', 'Buyer', 'Seller', 'Vendor', 'Contact',  
	function($scope, $http, $stateParams, Buyer, Seller, Vendor, Contact) {
		$scope.keyword = '';
		$scope.searchType = '';
		$scope.leads = [];
		$scope.lead = {};		
		$scope.totalBuyer = {};
		$scope.$stateParams = $stateParams;

		$scope.find = function() {
		if ($stateParams.searchType === 'Buyer') $scope.leads = Buyer.query({ action: 'search', search: $stateParams.keyword });
		 else if ($stateParams.searchType === 'Seller') $scope.leads = Seller.query({ action: 'search', search: $stateParams.keyword });
		 else if ($stateParams.searchType === 'Vendor') $scope.leads = Vendor.query({ action: 'search', search: $stateParams.keyword });
		 else if ($stateParams.searchType === 'Contact') $scope.leads = Contact.query({ action: 'search', search: $stateParams.keyword });
		
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