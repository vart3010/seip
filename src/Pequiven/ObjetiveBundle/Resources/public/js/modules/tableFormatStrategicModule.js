'use strict';
var tableFormatObjetiveStrategic = angular.module('tableFormatObjetiveStrategic', ['ngTable','ngTableExport'])
        .controller('TableObjetiveStrategicController', function($scope, ngTableParams, $http,sfTranslator,notifyService) {
            $scope.tableParams = new ngTableParams({
                page: 1, // show first page
                count: 10 // count per page
            }, {
                groupBy: 'line_strategics[0].ref',
                total: 0, // length of data
                getData: function($defer, params) {
                    var parameters = params.url();
                    parameters.limit = parameters.count;
                    var apiUrl = $scope.apiDataUrl;
                    $http.get(apiUrl, {params: parameters}).success(function(data) {
                        params.total(data._embedded.paginator.getNbResults);
                        $defer.resolve($scope.results = data._embedded.results);
                    });
                }
            });
            $scope.tableParams.search = '';

        });