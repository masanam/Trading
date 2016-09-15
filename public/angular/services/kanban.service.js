/*jshint undef: false, unused: false, indent: 2*/
/*global angular: false */
'use strict';

angular.module('order').service('BoardService', ['$uibModal', 'BoardManipulator', function ($uibModal, BoardManipulator) {

  return {
    removeCard: function (board, column, card) {
      if (confirm('Are You sure to Delete?')) {
        BoardManipulator.removeCardFromColumn(board, column, card);
      }
    },

    addNewCard: function (board, column) {
      var modalInstance = $uibModal.open({
        templateUrl: './angular/views/partials/newCard.html',
        controller: 'NewCardController',
        backdrop: 'static',
        resolve: {
          column: function () {
            return column;
          }
        }
      });
      modalInstance.result.then(function (cardDetails) {
        if (cardDetails) {
          BoardManipulator.addCardToColumn(board, cardDetails.column, cardDetails.title, cardDetails.details);
        }
      });
    },
    kanbanBoard: function (board) {
      var kanbanBoard = { name: board.name, numberOfColumns: board.numberOfColumns, columns: [], backlogs: [] };
      angular.forEach(board.columns, function (column) {
        BoardManipulator.addColumn(kanbanBoard, column.name);
        angular.forEach(column.cards, function (card) {
          BoardManipulator.addCardToColumn(kanbanBoard, column, card.title, card.details);
        });
      });
      return kanbanBoard;
    },
  };
}]);