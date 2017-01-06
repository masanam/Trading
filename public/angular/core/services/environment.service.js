'use strict';

// Environment service for user variables
angular.module('index').factory('Environment', ['$window',
  function ($window) {
    var env = {};

    env.env = $window.env;
    env.dist = $window.dist;
    env.trx = $window.trx;
    env.showBuy = $window.showBuy;
    env.destinationBy = $window.destinationBy;

    return env;
  }
]);