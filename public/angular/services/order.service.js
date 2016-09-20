'use strict';

angular.module('order').factory('SellOrder', ['$resource',
	function ($resource) {
		return $resource('api/sell_order/:option/:status/:id/:action/:sellerId', {
			id: undefined,
			action: undefined,
			sellerId: undefined,
		}, {
			update: {
				method: 'PUT'
			}
		});
	}
]);

angular.module('order').factory('BuyOrder', ['$resource',
	function ($resource) {
		return $resource('api/buy_order/:option/:id/:action/:status/:buyerId', {
      option:undefined,
			id: undefined,
			action: undefined,
			status: undefined,
      buyerId:undefined
		}, {
			update: {
				method: 'PUT'
			}
		});
	}
]);

angular.module('order').factory('Order', ['$resource',
	function ($resource) {
		return $resource('api/buy_sell_order/:option/:id/:action/:status/:sellerId', {
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