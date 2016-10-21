'use strict';

angular.module('lead').controller('LeadController', ['$scope', '$state', '$http', '$stateParams', 'Buyer', 'Seller', 'Vendor', 'Contact', 'Concession', 'Product', 'Lead',  
  function($scope, $state, $http, $stateParams, Buyer, Seller, Vendor, Contact, Concession, Product, Lead) {
    $scope.searchType = 'buyer';
    $scope.leads = [];
    $scope.lead = {};   
    $scope.totalBuyer = {};
    $scope.$stateParams = $stateParams;
    
    $scope.initSearch = function(){
      $scope.keyword = $scope.$stateParams.keyword;
      switch($state.current.name){
        case 'lead.seller' : $scope.searchType = 'seller'; break;
        case 'lead.vendor' : $scope.searchType = 'vendor'; break;
        case 'lead.contact' : $scope.searchType = 'contact'; break;
        default : $scope.searchType = 'buyer';
      }
    };

    $scope.search = function() {
      switch($scope.searchType){
        case 'seller' : $state.go('lead.seller', { keyword: $scope.keyword }); break;
        case 'vendor' : $state.go('lead.vendor', { keyword: $scope.keyword }); break;
        case 'contact' : $state.go('lead.contact', { keyword: $scope.keyword }); break;
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
      $scope.totalBuyer = Buyer.get({ action : 'total' });
      $scope.totalSeller = Seller.get({ action : 'total' });
      $scope.totalVendor = Vendor.get({ action : 'total' });
      $scope.totalContact = Contact.get({ action : 'total' });
      $scope.totalConcession = Concession.get({ action : 'total' });
      $scope.totalProduct = Product.get({ action : 'total' });
    };
  }
]);
