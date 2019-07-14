



app.controller('Settings', function($scope, $http) {




	//placement duration sales cutoff Commission begins
	$scope.fetch_min_withrawal = function () {
	     $http.get($base_url+"/settings/fetch_min_withrawal/")
	                .then(function(response) {
	                  console.log(response.data);
	                  $scope.$min_withrawal= response.data;
	                });

	                    };
	  $scope.fetch_min_withrawal();

	  $scope.update_min_withrawal =  function(){
			$data = 'content='+(JSON.stringify($scope.$min_withrawal));
			    $.ajax({
			            type: "POST",
			            url: $base_url+"/settings/update_min_withrawal/",
			            cache: false,
			            data: $data,
			            success: function(data) {
			            	// console.log(data);
			            notify();
			            },
			            error: function (data) {
			                 //alert("fail"+data);
			            }            

			        });
	  							};
	//placement duration sales cutoff Commission ends




	//placement duration sales cutoff Commission begins
	$scope.fetch_payments_timeout = function () {
	     $http.get($base_url+"/settings/fetch_payments_timeout/")
	                .then(function(response) {
	                  console.log(response.data);
	                  $scope.$payments_timeout= response.data;
	                });

	                    };
	  $scope.fetch_payments_timeout();

	  $scope.update_payments_timeout =  function(){
			$data = 'content='+(JSON.stringify($scope.$payments_timeout));
			    $.ajax({
			            type: "POST",
			            url: $base_url+"/settings/update_payments_timeout/",
			            cache: false,
			            data: $data,
			            success: function(data) {
			            	// console.log(data);
			            notify();
			            },
			            error: function (data) {
			                 //alert("fail"+data);
			            }            

			        });
	  							};
	//placement duration sales cutoff Commission ends











	
	//fetch_min_rank_to_earn_generational_bonus begins
	$scope.fetch_admin_bank_details = function () {
	     $http.get($base_url+"/settings/fetch_admin_bank_details/")
	                .then(function(response) {
	                  console.log(response.data);
	                  $scope.$admin_bank_details= response.data;
	                });

	                    };
	  $scope.fetch_admin_bank_details();

	  $scope.update_admin_bank_details =  function(){
			$data = 'content='+(JSON.stringify($scope.$admin_bank_details));
			    $.ajax({
			            type: "POST",
			            url: $base_url+"/settings/update_admin_bank_details/",
			            cache: false,
			            data: $data,
			            success: function(data) {
			            	console.log(data);
			            notify();
			            },
			            error: function (data) {
			                 //alert("fail"+data);
			            }            

			        });
	  							};
	//fetch_MOQLLES ends




	
	//fetch_min_rank_to_earn_generational_bonus begins
	$scope.fetch_site_settings = function () {
	     $http.get($base_url+"/settings/fetch_site_settings/")
	                .then(function(response) {
	                  console.log(response.data);
	                  $scope.$site_settings= response.data;
	                });

	                    };
	  $scope.fetch_site_settings();

	  $scope.update_site_settings =  function(){
			$data = 'content='+(JSON.stringify($scope.$site_settings));
			    $.ajax({
			            type: "POST",
			            url: $base_url+"/settings/update_site_settings/",
			            cache: false,
			            data: $data,
			            success: function(data) {
			            	console.log(data);
			            notify();
			            },
			            error: function (data) {
			                 //alert("fail"+data);
			            }            

			        });
	  							};
	//fetch_MOQLLES ends










});









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


