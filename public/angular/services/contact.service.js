'use strict';

angular.module('contact').factory('Contact', ['$resource',
	function ($resource) {
		return $resource('api/contact/:id', {
			id: undefined
		}, {
			update: {
				method: 'PUT'
			}
		});
	}
]);