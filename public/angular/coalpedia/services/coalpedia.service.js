'use strict';

angular.module('coalpedia').factory('Coalpedia', ['$resource',
  function ($resource) {
    return $resource('api/coalpedia/:action', { action: 'total' });
  }
]);

angular.module('coalpedia').factory('Company', ['$resource',
  function ($resource) {
    return $resource('api/company/:id/:action', {
      id: '@id'
    }, {
      update: {
        method: 'PUT'
      }
    });
  }
]);

'use strict';

angular.module('coalpedia').factory('Area', ['$resource',
  function ($resource) {
    return $resource('api/area/:id/:option', {
      id: '@id',
      option: undefined
    }, {
      update: {
        method: 'PUT'
      }
    });
  }
]);
