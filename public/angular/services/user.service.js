'use strict';

angular.module('user').factory('User', ['$resource',
	function ($resource) {
		return $resource('api/user/:id', {
			id: undefined
		}, {
			update: {
				method: 'PUT'
			}
		});
	}
]);