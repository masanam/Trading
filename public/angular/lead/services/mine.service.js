'use strict';

angular.module('mine').factory('Mine', ['$resource',
	function ($resource) {
		return $resource('api/mine/:action/:id/:option', {
			action: undefined,
			sellerId: undefined,
			id: undefined,
			option: undefined
		}, {
			update: {
				method: 'PUT'
			}
		});
	}
]);