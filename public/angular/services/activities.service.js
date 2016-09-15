'use strict';

angular.module('index').factory('Activities', ['$resource',
	function ($resource) {
		//return $resource('api/news');
    return {
      query: [
                {
                  id:"1",
                  caption: 'Mochtar Suhadi finished the order #ORD-2016-004.',
                  published: new Date('2016-07-22 18:00:00'),
                  url: "#",
                },
                {
                  id:"2",
                  caption: 'Prasetyo Nugraha Gema cancelled the order #ORD-2016-003.',
                  published: new Date('2016-07-21 18:00:00'),
                  url: "#",
                },
                {
                  id:"3",
                  caption: 'Albert C Santos created the order #ORD-2016-002.',
                  published: new Date('2016-07-21 12:00:00'),
                  url: "#",
                },
              ]
    };
	}
]);