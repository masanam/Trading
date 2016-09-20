'use strict';

angular.module('deal').factory('SellDeal', ['$resource',
	function ($resource) {
		return $resource('api/sell_deal/:id/:sellerId', {
			id: undefined,
			sellerId: undefined,
		}, {
			update: {
				method: 'PUT'
			}
		});
	}
]);

angular.module('deal').factory('BuyDeal', ['$resource',
	function ($resource) {
		return $resource('api/buy_deal/:id/:buyerId', {
			id: undefined,
      buyerId:undefined
		}, {
			update: {
				method: 'PUT'
			}
		});
	}
]);


angular.module('deal').factory('Deal', function () {
	return {
    query: [
              {
                id:"1",
                trader_name: 'Mochtar Suhadi', 
                buyer_name: 'PT. Wilmar Nabati Indonesia, PT. SMART Dumai', 
                seller_name: 'PT Kuansing Inti Makmur', 
                vendor_name: '',
                deal_date: new Date('2016-07-22 18:00:00'),
                total_sales: 100000000,
                total_cogs: 5000000,
                volume: 1000,
                status: "c",
              },
              {
                id:"2",
                trader_name: 'Albert C Santos', 
                buyer_name: 'PT. Wilmar Nabati Indonesia', 
                seller_name: 'PT Kuansing Inti Makmur, PT Golden Energy Mines', 
                vendor_name: '',
                total_sales: 500000000,
                total_cogs: 10000000,
                deal_date: new Date('2016-07-21 18:00:00'),
                volume: 2500,
                status: "o",
              },
              {
                id:"3",
                trader_name: 'Mochtar Suhadi', 
                buyer_name: 'PT. Wilmar Nabati Indonesia', 
                seller_name: 'PT Kuansing Inti Makmur', 
                vendor_name: 'PT. Surveyor Indonesia', 
                deal_date: new Date('2016-07-21 12:00:00'),
                total_sales: 7500000000,
                total_cogs: 180000000,
                volume: 5000,
                status: "f",
              },
            ],
    get:{
          id:"1",
          trader_name: 'Mochtar Suhadi', 
          buyer_name: 'PT. Wilmar Nabati Indonesia<br/>PT. SMART Dumai', 
          seller_name: 'PT Kuansing Inti Makmur', 
          vendor_name: '',
          deal_date: new Date('2016-07-22 18:00:00'),
          total_sales: '100000000',
          total_cogs: '5000000',
          volume: '1000',
          status: "c",
        },
  }
});