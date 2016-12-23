'use strict';

angular.module('sales').controller('SalesController', ['$scope', '$stateParams', '$state','$uibModal', 
  function($scope, $stateParams, $state, $uibModal) {

    $scope.opendetailModal = function () {
      var modalInstance = $uibModal.open({
        windowClass: 'xl-modal',
        templateUrl: './angular/coaltradephase2/views/sales/modal.view.detail.html',
        controller: 'SalesModalController',
        scope: $scope,
      });
    };

    $scope.openaddveselModal = function () {
      var modalInstance = $uibModal.open({
        windowClass: 'xl-modal',
        templateUrl: './angular/coaltradephase2/views/sales/add_vesel.html',
        controller: 'SalesModalController',
        scope: $scope,
      });
    };

    //$scope.detail = [
        //{ ContractID:'CONTRACT0010',Costumer:'PT.ABC',Product:'',Tonnage:'30.000.000mt',Price:'$54',Planed:'MUST BE FILLED!' },
        //{ ContractID:'CONTRACT0011',Costumer:'PT.ABCD',Product:'',Tonnage:'40.000.000mt',Price:'$64',Planed:'MUST BE FILLED!' },   
        //{ ContractID:'CONTRACT0012',Costumer:'PT.ABCDE',Product:'',Tonnage:'42.000.000mt',Price:'$74',Planed:'MUST BE FILLED!' }    
    //]; 

    //$scope.click=function(ContractID){
      //$scope.contract=$scope.detail[ContractID];

    //};

  }
]);
