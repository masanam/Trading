/*jshint undef: false, unused: false, indent: 2*/
/*global angular: false */


'use strict';

angular.module('order').factory('BoardManipulator', function () {
  return {

    addColumn: function (board, columnName) {
      board.columns.push({ name: columnName, cards: [] });
    },

    addCardToColumn: function (board, column, cardTitle, details) {
      angular.forEach(board.columns, function (col) {
        if (col.name === column.name) {
          col.cards.push({ title: cardTitle, status: column.name, details: details});
        }
      });
    },
    removeCardFromColumn: function (board, column, card) {
      angular.forEach(board.columns, function (col) {
        if (col.name === column.name) {
          col.cards.splice(col.cards.indexOf(card), 1);
        }
      });
    },
    addCardToBacklog: function (board, backlogName, phaseName, task) {
      angular.forEach(board.backlogs, function (backlog) {
        if (backlog.name === backlogName) {
          angular.forEach(backlog.phases, function (phase) {
            if (phase.name === phaseName) {
              phase.cards.push({ title: task.title, status: task.status, details: task.details});
            }
          });
        }
      });
    }
  };
});
