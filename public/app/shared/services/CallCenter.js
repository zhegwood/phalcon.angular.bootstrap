app.factory("CallCenter",["$rootScope","$http","$q",function($rootScope,$http,$q){
	return {
		post: function(call,data,return_error) {
			$rootScope.$broadcast("ajax_error","");
			$rootScope.$broadcast("ajax_success","");
			var deferred = $q.defer();
			$http.post(call,data)
				.success(function(response){
					if (response.success) {
						deferred.resolve(response.data);
					} else {
						if (return_error) {
							deferred.reject(response.error);
						} else {
							$rootScope.$broadcast("ajax_error",response.error);
						}
					}
				})
				.error(function(){
					if (return_error) {
						deferred.reject("500: Server Error");
					} else {
						$rootScope.$broadcast("ajax_error","500: Server Error");
					}
				});
			return deferred.promise;
		},
		get: function(call,return_error) {
			$rootScope.$broadcast("ajax_error","");
			$rootScope.$broadcast("ajax_success","");
			var deferred = $q.defer();
			$http.get(call)
				.success(function(response){
					if (response.success) {
						deferred.resolve(response.data);
					} else {
						if (return_error) {
							deferred.reject(response.error);
						} else {
							$rootScope.$broadcast("ajax_error",response.error);
						}
					}
				})
				.error(function(){
					if (return_error) {
						deferred.reject("500: Server Error");
					} else {
						$rootScope.$broadcast("ajax_error","500: Server Error");
					}
				});
			return deferred.promise;
		}
	}
}]);
