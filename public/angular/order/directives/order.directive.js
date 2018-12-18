'use strict';

angular.module('order').directive('orderFulfillmentStatus', function() {
  return {
    templateUrl: './angular/order/directives/order-fulfillment-status.html',
  };
});

angular.module('order').directive('orderStatus', function() {
  return {
    templateUrl: './angular/order/directives/order-status.html',
  };
});


/*Made by Aryo Pradipta Gema 12 January 2017 14:08
* It is used for showing the quality of an order
**/
angular.module('order').directive('orderQuality', function() {
  return {
    scope: {
      inhouse: '=inhouse',
      quality: '=quality',
      buymin: '=buymin',
      buymax: '=buymax',
      buyreject: '=buyreject',
      buybonus: '=buybonus',
      sellmin: '=sellmin',
      sellmax: '=sellmax',
      sellreject: '=sellreject',
      sellbonus: '=sellbonus',
      unit: '=unit',
      productquality: '=productquality',
    },
    templateUrl: './angular/order/directives/order-quality.html'
  };
});
