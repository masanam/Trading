'use strict';

angular.module('coalpedia').controller('ContactModalController', ['$scope', '$uibModalInstance', '$timeout', '$interval', 'Contact', 'Company', 'contact', 'company',
  function($scope, $uibModalInstance, $timeout, $interval, Contact, Company, contact, company) {
    $scope.contact = contact;
    $scope.selected = {};

    $scope.find = function (keyword) {
      Contact.query({ q: keyword, company_id:company.id }, function(res){
        if(res.length > 0) $scope.contacts = res;
      });
    };

    $scope.create = function() {
      var contact = new Contact($scope.contact);
      contact.company_id = company.id;

      contact.$save(function(response) {
        $uibModalInstance.close(response);
      });
    };

    $scope.update = function() {
      $scope.contact.company_id = company.id;

      $scope.contact.$update({ id: $scope.contact.id }, function(response) {
        contact = response;
        $uibModalInstance.close(response);
      });
    };

    $scope.attach = function (contact) {
      Company.get({ id: company.id, action: 'attach', contact_id: $scope.selected.contact.id }, function(response){
        $uibModalInstance.close(response.contact);
      });
    };

    $scope.close = function () {
      $uibModalInstance.dismiss('cancel');
    };
  }
]);
