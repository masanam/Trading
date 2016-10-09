'use strict';

angular.module('buyer').factory('Buyer', ['$resource',
	function ($resource) {
		return $resource('api/buyer/:id/:action/:status/:search', {
			id: undefined,
			action: undefined,
			status: undefined,
			search: undefined
		}, {
			update: {
				method: 'PUT'
			}
		});
	}
]);