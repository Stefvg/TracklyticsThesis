/**
 * Created by stefvangils on 14/11/15.
 */
(function(){
    var app = angular.module('thesis', []);

    app.directive("buttons", function() {
        return {
            restrict: 'E',
            templateUrl: "/angular-extensions/buttons.html"
        };
    });

    app.controller("ButtonController", ['$scope', '$http', function($scope, $http) {
        var button = this;
        this.apps = ["test"];

        var error = location.search.split('error=')[1];
        var error = parseInt(decodeURIComponent(error));
        switch(error) {
            case 2:
                $scope.error = true;
                console.log("test");
                break;
        }


        $http.get('../php/getApps.php').success(function(data){
            button.apps = data;
        });

    }]);




})();

function getURL($app){
    return "https://svg-apache.iminds-security.be/dashboard.html?app=" + $app;
}

