'use strict';

angular.module('coalpedia').controller('ContactModalController', ['$scope', '$uibModalInstance', '$timeout', '$interval', 'Contact', 'contact', 'company',
  function($scope, $uibModalInstance, $timeout, $interval, Contact, contact, company) {
    $scope.contact = contact;
    $scope.selected = {};

    $scope.create = function() {
      var contact = new Contact($scope.contact);
      contact.company_id = company.id;

      contact.$save(function(response) {
        $uibModalInstance.close(response);
      });
    };

    $scope.update = function() {
      $scope.contact = new Contact($scope.contact);
      $scope.contact.company_id = company.id;

      $scope.contact.$update(function(response) {
        contact = response;
        $uibModalInstance.close(response);
      });
    };

    $scope.close = function () {
      $uibModalInstance.dismiss('cancel');
    };
  }
]);
