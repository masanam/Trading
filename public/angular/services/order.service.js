'use strict';

angular.module('order').factory('SellOrder', ['$resource',
	function ($resource) {
		return $resource('api/sell_order/:id', {
			id: undefined,
		}, {
			update: {
				method: 'PUT'
			}
		});
	}
]);

angular.module('order').factory('BuyOrder', ['$resource',
	function ($resource) {
		return $resource('api/buy_order/:id', {
			id: undefined,
		}, {
			update: {
				method: 'PUT'
			}
		});
	}
]);

angular.module('order').factory('Order', ['$resource',
	function ($resource) {
		return $resource('api/buy_sell_order/:option/:type/:id/:action/:status/:sellerId', {
    		option:undefined,
    		type:undefined,
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