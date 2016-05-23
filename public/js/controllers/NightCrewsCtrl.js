angular.module('NightCrewsCtrl', []).controller('NightCrewsCtrl', ['$scope', '$http', function ($scope, $http) {

    $scope.currentWeekCrews = [];
    $scope.upcomingWeekCrews = [];
    $scope.number = 7;
    $scope.getNumber = function (num) {
        return new Array(num);
    };

    $scope.clearForm = function () {
        for (var d in $scope.formData) {
            if ($scope.formData.hasOwnProperty(d))
                $scope.formData[d] = "";
        }
    };

    $http({
        method: 'POST',
        url: '.crews.php',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        // set the headers so angular passing info as form data (not request payload)
    }).success(function (data) {
        if (!data.success) {
            console.log(data);
            console.log("it failed!");
            // if not successful, bind errors to error variables

            $scope.submission = true; //shows the error message
        } else {
            // Since the crews come in order of latest first, we need to separate
            // them in a way that almost seems backwards.

            $scope.currentWeekCrews = data.result.slice(7);
            $scope.upcomingWeekCrews = data.result.slice(0, 7);
        }
    });

    $scope.formatName = function (first, last) {
        return first ? (first.substr(0,1) + '. ' + last) : (last ? last : '');
    };

    $scope.canDelete = function (id) {
        // TODO: write logic for when someone can remove someone from crews
        return id > 0 ? true: false;
    }
}]);
