angular.module('index').filter('convertToDate', function() {
  return function(str){
    return new Date(str);
  };
});