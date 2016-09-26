'use strict';

angular.module('deal').factory('SellDeal', ['$resource',
	function ($resource) {
		return $resource('api/sell_deal/:action/:id/:sellerId/:dealId', {
      action: undefined,
			id: undefined,
			sellerId: undefined,
			dealId: undefined,
		}, {
			update: {
				method: 'PUT'
			}
		});
	}
]);

angular.module('deal').factory('BuyDeal', ['$resource',
	function ($resource) {
		return $resource('api/buy_deal/:action/:id/:buyerId/:dealId', {
			action: undefined,
      id: undefined,
      buyerId:undefined,
      dealId: undefined,
		}, {
			update: {
				method: 'PUT'
			}
		});
	}
]);


angular.module('deal').factory('Deal', ['$resource',
	function ($resource) {
		return $resource('api/deal/:action/:id/:status', {}, {
			update: {
				method: 'PUT'
			}
		});
	}
]);