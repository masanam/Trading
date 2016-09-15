'use strict';

angular.module('trade').factory('Trade', ['$resource',
	function ($resource) {
		return $resource('api/order/:id', {
			id: undefined,
		}, {
			update: {
				method: 'PUT'
			}
		});
	}
]);