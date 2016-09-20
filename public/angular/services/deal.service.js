'use strict';

angular.module('deal').factory('SellDeal', ['$resource',
	function ($resource) {
		return $resource('api/sell_deal/:id/:sellerId', {
			id: undefined,
			sellerId: undefined,
		}, {
			update: {
				method: 'PUT'
			}
		});
	}
]);

angular.module('deal').factory('BuyDeal', ['$resource',
	function ($resource) {
		return $resource('api/buy_deal/:id/:buyerId', {
			id: undefined,
      buyerId:undefined
		}, {
			update: {
				method: 'PUT'
			}
		});
	}
]);


angular.module('deal').factory('Deal', ['$resource',
	function ($resource) {
		return $resource('api/deal/:id', {
			id: undefined
		}, {
			update: {
				method: 'PUT'
			}
		});
	}
]);