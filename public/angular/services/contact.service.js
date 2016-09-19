'use strict';

angular.module('contact').factory('Contact', ['$resource',
	function ($resource) {
		return $resource('api/contact/:id/:search', {
			id: undefined,
			search: undefined
		}, {
			update: {
				method: 'PUT'
			}
		});
	}
]);