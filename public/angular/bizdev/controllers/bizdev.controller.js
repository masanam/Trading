'use strict';

angular.module('bizdev').controller('BizdevController', ['$scope', '$stateParams', 'Authentication', '$location','$uibModal', 
	function($scope, $stateParams, Authentication, $location, $uibModal) {
  $scope.labels1 = ['2014', '2015', '2016'];
  $scope.series1 = ['Offer Approved to Level 2', 'On Progress', 'Offer Rejected'];

  $scope.data1 = [
    [12, 15, 20],
    [3, 4, 5],
    [19, 25, 26]
  ];

  $scope.labels2 = ['Total Offer', 'Offer Rejected', 'Offer Approved to Level 2', 'On Progress'];
  $scope.series2 = ['2016 Proposal Review Status'];

  $scope.data2 = [
    [51, 26, 20, 5]
  ];

  $scope.labels3 = ['Land Use', 'Data License', 'Infrastucture', 'Geological', 'Others'];
  $scope.data3 = [5, 6, 3, 8, 4];

  $scope.labels4 = ['South Sumatra', 'Jambi', 'Bengkulu', 'West Sumatra', 'East Kalimantan', 'West Kalimantan', 'South Kalimantan', 'North Kalimantan'];
  $scope.data4 = [7, 9, 4, 2, 9, 7, 6, 7];
	}
]);