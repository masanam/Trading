'use strict';

angular.module('lead').controller('LeadController', ['$scope','$http', '$stateParams', 'Buyer', 'Seller', 'Vendor', 'Contact',  
	function($scope, $http, $stateParams, Buyer, Seller, Vendor, Contact) {
		$scope.keyword = '';
		$scope.searchType = '';
		$scope.leads = [];
		$scope.lead = {};		
		$scope.totalBuyer = {};

		$scope.find = function() {
			if ($stateParams.searchType === 'buyer') {
				$scope.leads = Buyer.query({ search: $stateParams.keyword });
			} else if ($stateParams.searchType === 'seller') {
				$scope.leads = Seller.query({ search: $stateParams.keyword });
			} else if ($stateParams.searchType === 'vendor') {
				$scope.leads = Vendor.query({ search: $stateParams.keyword });
			} else if ($stateParams.searchType === 'contact') {
				$scope.leads = Contact.query({ search: $stateParams.keyword });
			} else if ($stateParams.searchType === 'all') {
				$scope.leads = Lead.query({ search: $stateParams.keyword });
			}
		} 
		
		$scope.total = function ()
		{
			$scope.totalBuyer = Buyer.get({action : 'total'});									
			$scope.totalSeller = Seller.get({action : 'total'});
			$scope.totalVendor = Vendor.get({action : 'total'});
			$scope.totalContact = Contact.get({action : 'total'});
		}
}]);