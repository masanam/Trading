'use strict';

angular.module('vendor').factory('Vendor', ['$resource',
	function ($resource) {
		return $resource('api/vendor/:id/:action/:status', {
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