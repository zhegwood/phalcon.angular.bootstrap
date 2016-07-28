app.factory("CallCenter",["$rootScope","$http","$q",function($rootScope,$http,$q){
	return {
		post: function(call,data,return_error) {
			$rootScope.errorMessage = "";
			$rootScope.successMessage = "";
			$rootScope.processing = true;
			var deferred = $q.defer();
			$http.post(call,data)
				.success(function(response){
					if (response.success) {
						$rootScope.processing = false;
						deferred.resolve(response.data);
					} else {
						$rootScope.processing = false;
						if (return_error) {
							deferred.reject(response.error);
						} else {
							$rootScope.errorMessage = response.error;
						}
					}
				})
				.error(function(){
					$rootScope.processing = false;
					if (return_error) {
						deferred.reject("500: Server Error");
					} else {
						$rootScope.errorMessage = "500: Server Error";
					}
				});
			return deferred.promise;
		},
		get: function(call,return_error) {
			$rootScope.errorMessage = "";
			$rootScope.successMessage = "";
			$rootScope.processing = true;
			var deferred = $q.defer();
			$http.get(call)
				.success(function(response){
					if (response.success) {
						$rootScope.processing = false;
						deferred.resolve(response.data);
					} else {
						$rootScope.processing = false;
						if (return_error) {
							deferred.reject(response.error);
						} else {
							$rootScope.errorMessage = response.error;
						}
					}
				})
				.error(function(){
					$rootScope.processing = false;
					if (return_error) {
						deferred.reject("500: Server Error");
					} else {
						$rootScope.errorMessage = "500: Server Error";
					}
				});
			return deferred.promise;
		}
	}
}]);
