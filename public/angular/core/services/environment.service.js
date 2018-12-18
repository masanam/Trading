'use strict';

// Environment service for user variables
angular.module('index').factory('Environment', ['$window',
  function ($window) {
    var env = {};

    env.deployment = $window.deployment;
    env.env = $window.env;
    env.dist = $window.dist;
    env.trx = $window.trx;
    env.showBuy = $window.showBuy;
    env.showAutoApproval = $window.showAutoApproval;
    env.hideCrossingLead = $window.hideCrossingLead;
    env.showAllLead = $window.showAllLead;
    env.resetApprovalOnUpdate = $window.resetApprovalOnUpdate;
    env.destinationBy = $window.destinationBy;
    env.productQuality = $window.productQuality;
    env.defaultCurrency = $window.defaultCurrency;
    env.allowRetrachApproval = $window.allowRetrachApproval;
    env.allowEditAfterApproval = $window.allowEditAfterApproval;

    return env;
  }
]);
