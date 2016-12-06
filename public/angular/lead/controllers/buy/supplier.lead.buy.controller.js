'use strict';

angular.module('lead').controller('SupplierLeadBuyController', ['$scope', '$stateParams', '$location', '$uibModal', 'Company', 'Lead','Order', 'NgMap',
  function ($scope, $stateParams, $location, $uibModal, Company, Lead, Order, NgMap) {

    $scope.seller = {};
    $scope.id = $stateParams.id;

    //Init select supplier
    $scope.findCompanies = function() {
      $scope.companies = Company.query({ 'type[]': ['s'] });
    };

    //button next to concession page
    $scope.nextToConcession = function(id){
      $scope.lead = id ;
      //new lead
      if ($scope.lead.id===undefined) {
        $scope.lead = new Lead({
          company_id: $scope.seller.selected.id
        });
        $scope.lead.$save({ lead_type: 'buy' }, function(res) {
          $location.path('lead/create/concession/'+res.id+'/'+$scope.seller.selected.id);
        });
      }
      //lead from back
      else if ($scope.lead.id) {
        $scope.lead = new Lead({
          company_id: $scope.seller.selected.id,
          order_status: 1
        });
        $scope.lead.$update({ lead_type: 'buy', id: $stateParams.id }, function(res) {
          $location.path('lead/buy/create/concession/'+res.id+'/'+$scope.seller.selected.id);
        });
      }
    };

    //open modal create supplier
    $scope.openModal = function () {
      var modalInstance = $uibModal.open({
        windowClass: 'xl-modal',
        templateUrl: './angular/order/views/sell-order/modal.supplier.view.html',
        controller: 'ModalSellOrderController',
        scope: $scope
      });
    };

  }
]);