'use strict';

angular.module('index').directive('ngStaticInclude', [ '$http', '$templateCache', '$compile',
  function($http, $templateCache, $compile) {
    return {
      restrict: 'A',
      transclude: true,
      replace: true,
      scope:false,
      link: function($scope, element, attrs, ctrl, transclude) {
        var templatePath = attrs.ngStaticInclude;

        try{
          templatePath = $scope.$eval(templatePath);
        }catch(err){
          throw new Error(attrs.ngStaticInclude+' is not a valid object');
        }

        $http.get(templatePath, { cache: $templateCache })
        .success(function(response) {
          var contents = element.html(response).contents();
          $compile(contents)($scope.$parent);
        });
      }
    };
  }
]);