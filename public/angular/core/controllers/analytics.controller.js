'use strict';

angular.module('index').controller('AnalyticController', ['$state',
  function($state) {
    $state.go('lead.index');
	}
]);