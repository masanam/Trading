'use strict';

angular.module('firebaseService').factory('FirebaseService', ['firebase', '$firebaseArray', 'Environment', 
  function (firebase, $firebaseArray, Environment) {
    var config = {}; 

    if(Environment.env === 'production'){
      config = {
        apiKey: 'AIzaSyACILHAOiy4G9TtCgs0szgZBZokr4cduuo',
        authDomain: 'coal-trade.firebaseapp.com',
        databaseURL: 'https://coal-trade.firebaseio.com',
        storageBucket: 'coal-trade.appspot.com',
        messagingSenderId: '407921708335'
      };
    } else {
      config = {
        apiKey: 'AIzaSyASD5vZNA-DeS93cFU8oz40nycp1CIZ3bg',
        authDomain: 'coal-trade-dev.firebaseapp.com',
        databaseURL: 'https://coal-trade-dev.firebaseio.com',
        storageBucket: 'coal-trade-dev.appspot.com',
        messagingSenderId: '328150955221'
      };
    }

    var mainApp = firebase.initializeApp(config, 'webApps');

    return {
      mainApp: mainApp
    };
  }
]);