'use strict';

angular.module('deal').factory('Chat', ['$resource',
	function ($resource) {
		return $resource('api/chat/:id/:action/:status/:search', {
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