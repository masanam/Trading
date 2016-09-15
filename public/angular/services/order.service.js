'use strict';

angular.module('order').factory('Order', ['$resource',
	function ($resource) {
		return $resource('api/order/:option/:status/:id/:action/:buyerId', {
			id: undefined,
			action: undefined,
			buyerId: undefined,
		}, {
			update: {
				method: 'PUT'
			}
		});
	}
]);

angular.module('order').factory('OrderFulfillment', ['$resource',
	function ($resource) {
		return $resource('api/order-fulfillment/:option/:id/:action/:status/:sellerId', {
      option:undefined,
			id: undefined,
			action: undefined,
			status: undefined,
      sellerId:undefined
		}, {
			update: {
				method: 'PUT'
			}
		});
	}
]);