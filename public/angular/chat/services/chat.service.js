'use strict';

angular.module('chat').factory('BuyDealChat', ['$resource',
	function ($resource) {
		return $resource('api/buy-deal/chat/:id/:action/:status/:search', {
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

angular.module('chat').factory('SellDealChat', ['$resource',
	function ($resource) {
		return $resource('api/sell-deal/chat/:id/:action/:status/:search', {
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