'use strict';

angular.module('deal').factory('SellDeal', ['$resource',
  function ($resource) {
    return $resource('api/sell-deal/:action/:id/:sellerId/:orderId/:dealId', {
      action: undefined,
      id: undefined,
      sellerId: undefined,
      orderId: undefined,
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
    return $resource('api/buy-deal/:action/:id/:buyerId/:orderId/:dealId', {
      action: undefined,
      id: undefined,
      buyerId: undefined,
      orderId: undefined,
      dealId: undefined,
    }, {
      update: {
        method: 'PUT'
      }
    });
  }
]);

angular.module('deal').factory('OrderDeal', ['$resource',
  function ($resource) {
    return $resource('api/order-deal/:action/:entity/:id/:buyerId/:dealId/:userId', {
      action: undefined,
      entity: undefined,
      id: undefined,
      buyerId:undefined,
      dealId: undefined,
      userId: undefined,
    }, {
      update: {
        method: 'PUT'
      }
    });
  }
]);

angular.module('deal').factory('Deal', ['$resource',
  function ($resource) {
    return $resource('api/deal/:action/:id/:status/:userId', {
      action: undefined,
      id: undefined,
      status: undefined,
      userId: undefined,
    }, {
      update: {
        method: 'PUT'
      }
    });
  }
]);
