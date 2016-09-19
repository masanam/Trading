'use strict';

angular.module('lead').controller('LeadController', ['$scope', '$stateParams', 'Buyer', 'Seller', 'Vendor', 'Contact',  
	function($scope, $stateParams, Buyer, Seller, Vendor, Contact) {
		$scope.keyword = '';
		$scope.searchType = '';
		$scope.leads = [];
		$scope.lead = {};

		$scope.find = function() {
			if ($stateParams.searchType === 'Buyer') {
				$scope.leads = Buyer.query({ search: $stateParams.keyword });
			} else if ($stateParams.searchType === 'Seller') {
				$scope.leads = Seller.query({ search: $stateParams.keyword });
			} else if ($stateParams.searchType === 'Vendor') {
				$scope.leads = Vendor.query({ search: $stateParams.keyword });
			} else if ($stateParams.searchType === 'Contact') {
				$scope.leads = Contact.query({ search: $stateParams.keyword });
			}
		} 
}]);