'use strict';

angular.module('contact').controller('ContactController', ['$scope', 'Contact',
  function($scope, Contact) {
    $scope.contacts = [];
    $scope.contact = {};

    $scope.find = function() {
      $scope.contacts = Contact.query();
    };

    $scope.findOne = function(id) {
      $scope.contact = Contact.get({ id: id });
    }
}]);