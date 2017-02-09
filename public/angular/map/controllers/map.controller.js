// ======================================
// edited by : hasapu
// 08-02-2017
// Penambahan Maps untuk Customer
//=======================================

'use strict';

angular.module('map').controller('MapController', ['$scope','$http', '$stateParams', '$state', 'Map', 'Concession', 'Port', 'NgMap','Environment','Company','Country',
  function($scope,$http, $stateParams, $state, Map, Concession, Port, NgMap, Environment, Company, Country) {
    //$scope.filters = [{ field:'gcv_arb', operand: '>=', number: 5000 }];
    $scope.showBuy = Environment.showBuy;
    $scope.filters = [];
    $scope.search = {};
    $scope.concession = {};
    $scope.concessions = [];
    $scope.ports = [];
    $scope.product = undefined;

    $scope.countries = Country.query();
    $scope.filter_country = 'Indonesia';

    $scope.customIcon = {
      scaledSize: [32, 32],
      url: 'http://www.cliparthut.com/clip-arts/823/arrowhead-clip-art-823528.png'
    };

    NgMap.getMap().then(function(map) {
      $scope.map = map;
    });

    $scope.find = function() {
      var params = {};
      
      if ($scope.showBuy) {
        $scope.filters_gt = [];
        $scope.filters_lt = [];
        $scope.filters_bet = [];

        var temp_filter = [];

        $scope.search_port = [];
        $scope.search_product = [];
        $scope.search_concession = [];
        $scope.search_seller = [];

        var temp_search = [];


        if($scope.search || $scope.filters.length > 0){
          if($scope.search){
            if($scope.search.category === 'port'){
              temp_search = $scope.search_port;
            }
            else if($scope.search.category === 'product'){
              temp_search = $scope.search_product;
            }
            else if($scope.search.category === 'concession'){
              temp_search = $scope.search_concession;
            }
            else if($scope.search.category === 'seller'){
              temp_search = $scope.search_seller;
            }
            temp_search.push($scope.search.keyword);

            params.product = $scope.search_product[0];
            params.port = $scope.search_port[0];
            params.seller = $scope.search_seller[0];
            params.concession = $scope.search_concession[0];
          }

          if($scope.filters.length > 0){
            for(var i = 0; i < $scope.filters.length; i++){
              if($scope.filters[i].operand === '>='){
                temp_filter = $scope.filters_gt;
              }
              else if($scope.filters[i].operand === '<='){
                temp_filter = $scope.filters_lt;
              }
              else{
                temp_filter = $scope.filters_bet;
              }
              temp_filter.push($scope.filters[i].field+','+$scope.filters[i].number);
            }

            params['gt[]'] = $scope.filters_gt;
            params['lt[]'] = $scope.filters_lt;
            params['bet[]'] = $scope.filters_bet;
          }

        }

        params.action = 'filter';

        $scope.concessions = Concession.query(params);
      }
      else {
        // console.log($scope.search.category);

        $scope.companies = Company.query({ company_type: 'c' });
        // console.log($scope.companies);
        console.log($scope.filter_country);


      }
      params.action = 'filter';
      params.country = $scope.filter_country;
      console.log(params);

      Concession.query(params, function(res){
        for (var i = res.length - 1; i >= 0; i--) {
          res[i].polygon = angular.fromJson(res[i].polygon);
        }
        $scope.concessions = res;
      });
    };

    $scope.addFilter = function(){
      $scope.filters.push({ field:'', operand: '', number: 0 });
    };

    $scope.deleteFilter = function(filter){
      $scope.filters.splice($scope.filters.indexOf(filter), 1);
      $scope.find();
    };

    $scope.resetFilter = function(){
      $scope.filters = [];
      $scope.find();
    };

    $scope.showDetail = function(event, concession_id) {
      $scope.concession = Concession.get({ id: concession_id }, function(res) {
        res.polygon = angular.fromJson(res.polygon);
        $scope.concession = res;
        $scope.map.showInfoWindow('info-window', event.latLng);

        $scope.product = undefined;
      });
    };

    $scope.showPortDetail = function(event, port, showBuy) {
      if(showBuy){
        $scope.connectedConcessions = Port.get({ id: port.id });
        $scope.port = Port.get({ id: port.id }, function(port) {
          $scope.event = event;
          $scope.port = port;
          $scope.map.showInfoWindow('port-info-window', event.latLng);
          $scope.product = undefined;
        });
      }
      else{
        $scope.company = Company.get({ id: port }, function(port) {
          $scope.event = event;
          $scope.map.showInfoWindow('company-info-window', event.latLng);
        });
      }


    };

    $scope.showProduct = function(event,product,showBuy) {
      if(showBuy) {
        $scope.product = product;
      }
      else {
        console.log('disini');
        console.log(product);
        $scope.map.showInfoWindow('factory-info-window', event.latLng);
      }

    };

    $scope.selectPill = function(index){
      $scope.selectedPill = index;
    };

  }
]);
