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
<<<<<<< HEAD
		return $resource('api/deal/:id', {}, {
=======
		return $resource('api/deal/:action/:id/:status', {
      action: undefined,
			id: undefined,
      status: undefined,
		}, {
>>>>>>> bfcb76d12b479bb468f582ce23fd6a4c14342025
			update: {
				method: 'PUT'
			}
		});
	}
]);