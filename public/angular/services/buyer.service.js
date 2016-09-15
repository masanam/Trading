'use strict';

angular.module('buyer').factory('Buyer', ['$resource',
	function ($resource) {
		return $resource('api/buyer/:id/:action/:status', {
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