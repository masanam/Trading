'use strict';

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
      'TT', 'LC', 'LC USANCE'
    ]
  };
});
