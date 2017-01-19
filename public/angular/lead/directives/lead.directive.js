'use strict';

/*Made by Aryo Pradipta Gema 12 January 2017 14:08
* It is used for showing the quality of a lead
**/
angular.module('lead').directive('leadQuality', function() {
  return {
    restrict: 'A',
    scope: {
      min: '=min',
      max: '=max',
      reject: '=reject',
      bonus: '=bonus',
      quality: '=quality'
    },
    templateUrl: './angular/lead/directives/lead-quality.html'
  };
});