'use strict';

angular.module('seller').factory('Seller', ['$resource',
	function ($resource) {
		return $resource('api/seller/:id/:action/:status', {
      id: undefined,
			action: undefined,
			status: undefined
		}, {
			update: {
				method: 'PUT'
			}
		});
	}
]);