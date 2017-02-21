'use strict';

angular.module('firebaseService').factory('FirebaseService', ['firebase', '$firebaseArray', 'Environment',
  function (firebase, $firebaseArray, Environment) {
    var config = {};

    if(Environment.env === 'production'){
      if(Environment.deployment === 'bib') {
        config = {
          apiKey: 'AIzaSyACILHAOiy4G9TtCgs0szgZBZokr4cduuo',
          authDomain: 'coal-trade.firebaseapp.com',
          databaseURL: 'https://coal-trade.firebaseio.com',
          storageBucket: 'coal-trade.appspot.com',
          messagingSenderId: '407921708335'
        };
      } else if(Environment.deployment === 'berau') {
        config = {
          apiKey: 'AIzaSyCxlQjskah9WwqykW9oU3k6250HQWfhfws',
          authDomain: 'coal-trade-bce.firebaseapp.com',
          databaseURL: 'https://coal-trade-bce.firebaseio.com',
          storageBucket: 'coal-trade-bce.appspot.com',
          messagingSenderId: '202440433886'
        };
      }
    } else {
      if(Environment.deployment === 'bib') {
        config = {
          apiKey: 'AIzaSyASD5vZNA-DeS93cFU8oz40nycp1CIZ3bg',
          authDomain: 'coal-trade-dev.firebaseapp.com',
          databaseURL: 'https://coal-trade-dev.firebaseio.com',
          storageBucket: 'coal-trade-dev.appspot.com',
          messagingSenderId: '328150955221'
        };
      } else if(Environment.deployment === 'berau') {
        config = {
          apiKey: 'AIzaSyCA9Y_d68CnRkKtZLeqNT0GheGx0SIlljM',
          authDomain: 'coal-trade-bce-dev.firebaseapp.com',
          databaseURL: 'https://coal-trade-bce-dev.firebaseio.com',
          storageBucket: 'coal-trade-bce-dev.appspot.com',
          messagingSenderId: '79426855083'
        };
      }
    }

    var mainApp = firebase.initializeApp(config, 'webApps');

    return {
      mainApp: mainApp
    };
  }
]);
