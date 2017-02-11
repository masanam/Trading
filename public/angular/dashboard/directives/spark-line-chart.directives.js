'use strict';

angular.module('index').directive('sparkLineChart', function () {
  return {
    restrict: 'E',
    scope: {
      data: '@'
    },
    compile: function (tElement, tAttrs, transclude) {
      var line = makeNode('line', tElement, tAttrs)
      var svg = tElement.replaceWith('<svg id="sparkchart" height="30px" width="100%"></svg>');

      return function (scope, element, attrs) {
        attrs.$observe('data', function (newValue) {
          var svgEle = svg[0];
          var line = document.createElementNS('http://www.w3.org/2000/svg', 'line');

          console.log('sele', svgEle);
          console.log('tele', tElement);

          line.setAttribute('x1', '0');
          line.setAttribute('x2', '0');
          line.setAttribute('x2', '20');
          line.setAttribute('y2', '20');

          line.setAttribute('style', 'stroke:grey;');

          svgEle.append(line);

          return line;
          //svgEle.append(compile(line)(scope));
        });
      };
    }
  };
});