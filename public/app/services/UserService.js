app.factory("UserService",["$rootScope","$q","CallCenter",function($rootScope,$q,CallCenter){
	
	function validLogin(user) {
		if (!user.email || user.email == "") {
			$rootScope.errorMessage = "Email Address is required.";
			return false;
		}
		if (!user.password || user.password == "") {
			$rootScope.errorMessage = "Password is required.";
			return false;
		}
		return true;
	}
	
	function validUser(user) {

		if (!user.email || user.email == "") {
			$rootScope.errorMessage = "Email Address is required.";
			return false;
		}
		if (!user.password || user.password == "") {
			$rootScope.errorMessage = "Password is required.";
			return false;
		}
		if (!user.confirm || user.password != user.confirm) {
			$rootScope.errorMessage = "Passwords do not match.";
			return false;
		}
		if (user.randomNum != user.sliderValue) {
			$rootScope.errorMessage = "Please prove your humanity.";
			return false;
		}
		if (!user.agree) {
			$rootScope.errorMessage = "You must agree to the terms of service.";
			return false;
		}

		return true;
	}
	
	return {
		createAccount: function(user) {
			var deferred = $q.defer();
			if (validUser(user)) {
				CallCenter.post("/ajax/create-account",user,true).then(
					function(){
						deferred.resolve();
					},
					function(error) {
						$rootScope.errorMessage = error;
						deferred.reject();
					}
				);
			} else {
				deferred.reject();
			}
			return deferred.promise;
		},
		login: function(user) {
			var deferred = $q.defer();
			if (validLogin(user)) {
				CallCenter.post("/ajax/login",user).then(
					function(data){
						deferred.resolve();
					},
					function(error) {
						deferred.reject();
					}
				);
			} else {
				deferred.reject();
			}
			return deferred.promise;
		},
		validEmail: function(user) {
			var deferred = $q.defer();
			if (user.email && user.email != "") {
				CallCenter.post("/ajax/valid-email",user,true).then(
					function(data){
						deferred.resolve(data);
					},
					function(){
						deferred.reject();
					}
				);
			} else {
				deferred.reject();
			}
			return deferred.promise;
		}
	};
}]);