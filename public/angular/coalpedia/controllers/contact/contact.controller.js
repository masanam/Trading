'use strict';

angular.module('coalpedia').controller('ContactController', ['$scope', '$stateParams', '$state', '$uibModal', 'Contact',
  function($scope, $stateParams, $state, $uibModal, Contact) {
    $scope.add = function () {
      var modalInstance = $uibModal.open({
        animation: true,
        ariaLabelledBy: 'modal-title',
        ariaDescribedBy: 'modal-body',
        templateUrl: './angular/coalpedia/views/contact/_create.modal.view.html',
        controller: 'ContactModalController',
        windowClass: 'xl-modal',
        resolve: {
          contact: new Contact(),
          company: $scope.company
        }
      });

      modalInstance.result.then(function (res) {
        if(!$scope.company.contacts) $scope.company.contacts = [];

        $scope.company.contacts.push(res);
      });
    };

    $scope.edit = function (contact) {
      var modalInstance = $uibModal.open({
        animation: true,
        ariaLabelledBy: 'modal-title',
        ariaDescribedBy: 'modal-body',
        templateUrl: './angular/coalpedia/views/contact/_update.modal.view.html',
        controller: 'ContactModalController',
        windowClass: 'xl-modal',
        resolve: {
          contact: Contact.get({ id: contact.id }),
          company: $scope.company
        }
      });

      modalInstance.result.then(function (res) {
        if(!$scope.company.contacts) $scope.company.contacts = [];
        $scope.company.contacts.splice($scope.company.contacts.indexOf(contact), 1, res);
      });
    };

    $scope.delete = function (contact) {
      if(confirm('Are you sure you want to delete ' + contact.name + '?')){
        contact = new Contact(contact);
        contact.$remove(function (res){
          $scope.company.contacts.splice($scope.company.contacts.indexOf(contact), 1);
        });
      }
    };

    $scope.findOne = function(id) {
      if(id !== undefined){
        $scope.concessionId = id;
      } else {
        $scope.concessionId = $stateParams.id;
      }

      Contact.get({ id: $scope.concessionId }, function(concession){
        $scope.concession = concession;

        switch(concession.company.company_type){
          case 'c' : $scope.companyType = 'customer'; break;
          case 's' : $scope.companyType = 'supplier'; break;
          case 't' : $scope.companyType = 'supplier'; break;
          case 'v' : $scope.companyType = 'vendor'; break;
        }
      });
    };
  }
]);
