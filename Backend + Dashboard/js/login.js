/**
 * Created by stefvangils on 14/11/15.
 */
(function(){
    var app = angular.module('thesis', []);

    app.controller("LoginController", ['$scope', '$http', function($scope, $http) {

        var error = location.search.split('error=')[1];
        var error = parseInt(decodeURIComponent(error));
        switch(error) {
            case 1:
                $scope.error = true;

                break;
        }


        var login = this;
        login.incorrectUsername = false;
        $scope.submitForm = function () {
            var email = $scope.emailValue;
            var password = $scope.passwordValue;
            data = {
                'email' : email,
                'password' : password
            };
            $http.post('../php/authentication/login.php', data)
                .success(function(data, status)
                {
                    if(data == "Correct"){
                        window.location.replace('index.html');
                    }else {
                        login.incorrectUsername = true;
                    }
                })
        }

    }]);




})();