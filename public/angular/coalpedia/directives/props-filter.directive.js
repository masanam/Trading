'use strict';

angular.module('coalpedia').filter('propsFilter', function() {
  return function(items, props) {
    var out = [];

    if (items instanceof Array) {
      var keys = Object.keys(props);
        
      items.forEach(function(item) {
        var itemMatches = false;

        for (var i = 0; i < keys.length; i++) {
          var prop = keys[i];
          var text = props[prop].toLowerCase();
          if (item[prop].toString().toLowerCase().indexOf(text) !== -1) {
            itemMatches = true;
            break;
          }
        }

        if (itemMatches) {
          out.push(item);
        }
      });
    } else {
      // Let the output be the input untouched
      out = items;
    }

    return out;
  };
});

angular.module('coalpedia').filter('html', function($sce) {
  return function(val) {
    return $sce.trustAsHtml(val);
  };
});