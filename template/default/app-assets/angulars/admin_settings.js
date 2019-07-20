



app.controller('Settings', function($scope, $http) {


	
	$scope.fetch_site_settings = function () {
	     $http.get($base_url+"/settings/fetch_site_settings/")
	                .then(function(response) {
	                  console.log(response.data);
	                  $scope.$site_settings= response.data;
	                });

	                    };
	  $scope.fetch_site_settings();


	
	$scope.fetch_commission_settings = function () {
	     $http.get($base_url+"/settings/fetch_commission_settings/")
	                .then(function(response) {
	                  console.log(response.data);
	                  $scope.$commission_settings= response.data;
	                });

	                    };
	  $scope.fetch_commission_settings();

	
	$scope.fetch_pools_settings = function () {
	     $http.get($base_url+"/settings/fetch_pools_settings/")
	                .then(function(response) {
	                  console.log(response.data);
	                  $scope.$pools_settings= response.data;
	                });

	                    };
	  $scope.fetch_pools_settings();



});









app.filter('replace', [function () {

    return function (input, from, to) {
      
      if(input === undefined) {
        return;
      }
  
      var regex = new RegExp(from, 'g');
      return input.replace(regex, to);
       
    };


}]);




app.directive("contenteditable", function() {
  return {
    restrict: "A",
    require: "ngModel",
    link: function(scope, element, attrs, ngModel) {

      function read() {
        ngModel.$setViewValue(element.html());
      }

      ngModel.$render = function() {
        element.html(ngModel.$viewValue || "");
      };

      element.bind("blur keyup change", function() {
        scope.$apply(read);
      });
    }
  };
});

