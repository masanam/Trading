'use strict';

angular.module('lead').controller('LeadController', ['$scope','$http', '$stateParams', 'Buyer', 'Seller', 'Vendor', 'Contact', 'Lead',  
	function($scope, $http, $stateParams, Buyer, Seller, Vendor, Contact, Lead) {
		$scope.keyword = '';
		$scope.searchType = 'All';
		$scope.leads = [];
		$scope.lead = {};		
		$scope.totalBuyer = {};
		$scope.$stateParams = $stateParams;

		$scope.find = function() {
			$scope.searchType = $stateParams.searchType;
			if ($scope.searchType == 'Buyer') {
				if($stateParams.keyword) $scope.leads = Buyer.query({ search: $stateParams.keyword });
				else $scope.leads = Buyer.query();
			} else if ($scope.searchType == 'Seller') {
				if($stateParams.keyword) $scope.leads = Seller.query({ search: $stateParams.keyword });
				else $scope.leads = Seller.query();
			} else if ($scope.searchType == 'Vendor') {
				if($stateParams.keyword) $scope.leads = Vendor.query({ search: $stateParams.keyword });
				else $scope.leads = Vendor.query();
			} else if ($scope.searchType == 'Contact') {
				if($stateParams.keyword) $scope.leads = Contact.query({ search: $stateParams.keyword });
				else $scope.leads = Contact.query();
			} else if ($scope.searchType == 'All') {
				if($stateParams.keyword) $scope.leads = Lead.query({ search: $stateParams.keyword });
				else $scope.leads = Lead.query();
			}
		};

		$scope.findOne = function () {
			if ($stateParams.type == 'Buyer') $scope.lead = Buyer.get({ id: $stateParams.id });
			else if ($stateParams.type == 'Seller') $scope.lead = Seller.get({ id: $stateParams.id });
			else if ($stateParams.type == 'Vendor') $scope.lead = Vendor.get({ id: $stateParams.id });
			else if ($stateParams.type == 'Contact') $scope.lead = Contact.get({ id: $stateParams.id });
		
		};
		
		$scope.total = function () {
			$scope.totalBuyer = Buyer.get({action : 'total'});									
			$scope.totalSeller = Seller.get({action : 'total'});
			$scope.totalVendor = Vendor.get({action : 'total'});
			$scope.totalContact = Contact.get({action : 'total'});
		};
}]);