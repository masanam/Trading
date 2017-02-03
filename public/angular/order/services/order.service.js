'use strict';

angular.module('order').factory('Contract', ['$resource',
  function ($resource){
    return $resource('api/contracts/:id/:action', {
      id: '@id'
    }, {
      update: { method: 'PUT' },
      post: { method: 'POST' },
    });
  }
]);


angular.module('order').factory('Order', ['$resource',
  function ($resource) {
    return $resource('api/orders/:id/:action', {
      id: '@id'
    }, {
      update: { method: 'PUT' },
      post: { method: 'POST' },
    });
  }
]);

// angular.module('order').factory('Lead', ['$resource',
//   function ($resource){
//     return $resource('api/orders/:id', {
//       id: '@id',
//     }, {
//       update: { method: 'PUT' },
//     });
//   }
// ]);


angular.module('order').factory('Term', function (){
  return {
    trading : [
      'FOT', 'FOB BARGE', 'FOB MV', 'CNF', 'CIF', 'FRANCO'
    ],
    payment : [
      'TT', 'LC USANCE', 'LC SIGHT'
    ],
    additionalCost : [
      'Survey', 'Pit-to-Port', 'Transshipment', 'Freight', 'Port-to-Factory', 'Others'
    ],
    carrierTypes : [
      'Geared', 'Gearless', 'Geared & Gearless'
    ]
  };
});
