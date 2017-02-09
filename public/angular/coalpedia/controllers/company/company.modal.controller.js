'use strict';

angular.module('coalpedia').controller('CompanyModalController', ['$scope', '$uibModalInstance', '$timeout', '$interval', 'Environment', 'Company', 'Term', 'company', 'companyType', 'Area', 'Country',
  function($scope, $uibModalInstance, $timeout, $interval, Environment, Company, Term, company, companyType, Area, Country) {
    $scope.showBuy = Environment.showBuy;
    $scope.company = company;
    $scope.companyType = companyType;
    $scope.selected = {};
    $scope.term = Term;

    $scope.address = function() {
        // var geocoder = new google.maps.Geocoder();
        // if (geocoder) {
        //   geocoder.geocode({
        //     'address': $scope.company.address
        //   }, function (results, status) {
        //     if (status === google.maps.GeocoderStatus.OK) {
        //       var loc = results[0];
        //       $scope.company.latitude = loc.geometry.location.lat();
        //       $scope.company.longitude = loc.geometry.location.lng();
        //       console.log($scope.company.latitude);
        //     }
        //   });
        // }
    };

    $scope.changePosition = function(e) {
      $scope.company.latitude = e.latLng.lat();
      $scope.company.longitude = e.latLng.lng();
      //console.log($scope.company.latitude);
      //console.log($scope.company.longitude);
    };

    $scope.create = function() {
      //console.log('disini create');
      //valudation on company name
      if(!$scope.company.company_type) return alert('You must choose a company type!');

      var company = new Company($scope.company);
      //console.log(company);

      company.$save({ type: company.company_type }, function(response) {
        $uibModalInstance.close(response);
      });
    };

    $scope.findCountries = function(){
      $scope.countries = Country.query();
    };

    $scope.findAreas = function(){
      $scope.areas = Area.query();
    };

    $scope.update = function() {
      var company = $scope.company;

      company.$update({ id: $scope.company.id }, function(response) {
        $uibModalInstance.close(response);
      });
    };

    $scope.close = function () {
      $uibModalInstance.dismiss('cancel');
    };
  }
]);
