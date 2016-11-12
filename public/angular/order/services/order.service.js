'use strict';

angular.module('order').factory('Order', ['$resource',
  function ($resource) {
    return $resource('api/order/:type/:id/:action/:order_status/:progress_status/:user_id', {
      type: undefined,
      id: '@id',
      action: undefined,
      order_status: undefined,
      progress_status: undefined,
      user_id: undefined,
    }, {
      update: { method: 'PUT' }
    });
  }
]);

angular.module('order').factory('OrderUser', ['$resource',
  function ($resource) {
    return $resource('api/order/:orderId/user/:userId', {
      orderId: undefined,
      userId: undefined
    }, {
      update: { method: 'PUT' }
    });
  }
]);

angular.module('order').factory('Term', function (){
  return {
    trading : [
      'FOT', 'FOB BARGE', 'FOB MV', 'CNF', 'CIF', 'FRANCO'
    ],
    payment : [
      'PIA', 'NET7', 'NET30', 'EOM', 'COD', 'CND', 'CBS'
    ]
  };
});