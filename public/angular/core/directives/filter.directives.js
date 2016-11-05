'use strict';

angular.module('index').filter('convertToDate', function() {
  return function(str){
    return new Date(str);
  };
});

angular.module('index').filter('firstWord', function() {
  return function(str){
    if(!str) return str;
    str = str.split(' ');
    return str[0];
  };
});