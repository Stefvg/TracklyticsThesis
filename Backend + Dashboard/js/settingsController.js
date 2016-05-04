/**
 * Created by stefvangils on 30/03/16.
 */
(function(){
    var app = angular.module('settings', ['uiSwitch']);
    app.controller('SettingsController', ['$scope','$http', function ($scope, $http) {


        var settings = this;
        settings.enabled = 1;
        settings.aggregation = 0;
        settings.disk = 0;

        var app = location.search.split('app=')[1];
        app = decodeURIComponent(app);

        $http.get('../php/ShouldMonitor.php?app=' + app).success(function(data){
            settings.enabled = parseInt(data);
        });
        $http.get('../php/ShouldAggregateOnDevice.php?app=' + app).success(function(data){
            settings.aggregation = parseInt(data);
        });
        $http.get('../php/ShouldSaveOnDisk.php?app=' + app).success(function(data){
            settings.disk = parseInt(data);
        });
        $http.get('../php/getAppCode.php?app=' + app).success(function(data){
            $scope.appCode = data;
        });



        $scope.changeCallback = function() {
            var value = settings.enabled ? 1 : 0;
            $http.get('../php/ChangeShouldMonitor.php?app=' + app +'&value=' + value).success(function(data){
            });
        };
        $scope.changeAggregation = function() {
            var value = settings.aggregation ? 1 : 0;
            $http.get('../php/ChangeAggregationOnDevice.php?app=' + app +'&value=' + value).success(function(data){
            });
        };
        $scope.changeSaveOnDisk = function() {
            var value = settings.disk ? 1 : 0;
            $http.get('../php/ChangeSaveOnDisk.php?app=' + app +'&value=' + value).success(function(data){
            });
        };
    }]);
})(window.angular);