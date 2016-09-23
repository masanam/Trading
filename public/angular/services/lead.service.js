'use strict';

angular.module('lead').factory('Lead', ['$resource',
	function ($resource) {
		return $resource('api/lead/:id/:action/:status/:search', {
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