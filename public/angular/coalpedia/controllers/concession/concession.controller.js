'use strict';

angular.module('coalpedia').controller('ConcessionController', ['$scope', '$stateParams', '$state', '$uibModal', 'Concession',
  function($scope, $stateParams, $state, $uibModal, Concession) {
    $scope.selected = {};

    $scope.add = function () {
      var modalInstance = $uibModal.open({
        animation: true,
        ariaLabelledBy: 'modal-title',
        ariaDescribedBy: 'modal-body',
        templateUrl: './angular/coalpedia/views/concession/_create.modal.view.html',
        controller: 'ConcessionModalController',
        windowClass: 'xl-modal',
        resolve: {
          concession: new Concession(),
          company: $scope.company,
          createNew: false
        }
      });

      modalInstance.result.then(function (res) {
        if(!$scope.company.concessions) $scope.company.concessions = [];
        
        $scope.company.concessions.push(res);
      });
    };

    $scope.edit = function (concession) {      
      //console.log(concession.id);
      var modalInstance = $uibModal.open({
        animation: true,
        ariaLabelledBy: 'modal-title',
        ariaDescribedBy: 'modal-body',
        templateUrl: './angular/coalpedia/views/concession/_update.modal.view.html',
        controller: 'ConcessionModalController',
        windowClass: 'xl-modal',
        resolve: {
          concession: Concession.get({ id: concession.id }),
          company: $scope.company,
          createNew: false,
          edit:1
        }
      });

      modalInstance.result.then(function (res) {
        $scope.concession=res;
        if(!$scope.company.concessions) $scope.company.concessions = [];
        $scope.company.concessions.splice($scope.company.concessions.indexOf(concession), 1, res);
      });
    };

    $scope.find = function() {
      $scope.concessions = Concession.query({ q: $stateParams.keyword, type:$scope.searchType });
    };

    $scope.findOne = function(id) {
      if(id !== undefined){
        $scope.concessionId = id;
      } else {
        $scope.concessionId = $stateParams.id;
      }

      Concession.get({ id: $scope.concessionId }, function(concession){
        $scope.concession = concession;
        $scope.concession.polygon = angular.fromJson(concession.polygon);

        switch(concession.company && concession.company.company_type){
          case 'c' : $scope.companyType = 'customer'; break;
          case 's' : $scope.companyType = 'supplier'; break;
          case 't' : $scope.companyType = 'supplier'; break;
          case 'v' : $scope.companyType = 'vendor'; break;
        }
      });
    };
  }
]);
