'use strict';

angular.module('production').factory('Production', ['$resource',
	function ($resource) {
		return $resource('api/production/:id/:action/:sellerId', {
      id: undefined,
      action: undefined,
      sellerId: undefined,
    });
	}
]);