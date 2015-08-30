app.factory("Util", ["$rootScope", "$location", "$anchorScroll", "$q", "CallCenter",
function($rootScope, $location, $anchorScroll, $q, CallCenter) {
	return {
		modalError : function(error) {
			$rootScope.$broadcast("modal_error", error);
			this.scrollTo('modal-top');
		},
		mySQLDate : function(jsdt) {
			var Y = jsdt.getFullYear(), m = jsdt.getMonth() + 1, d = jsdt.getDate(), H = jsdt.getHours(), i = jsdt.getMinutes();

			m = m < 10 ? "0" + m : "" + m;
			d = d < 10 ? "0" + d : "" + d;
			H = H < 10 ? "0" + H : "" + H;
			i = i < 10 ? "0" + i : "" + i;

			return Y + "-" + m + "-" + d + " " + H + ":" + i + ":00";
		},
		scrollTo : function(where) {
			$location.hash(where);
			$anchorScroll();
		},
		showError : function(error) {
			$rootScope.$broadcast("ajax_error", error);
		},
		showSuccess : function(success) {
			$rootScope.$broadcast("ajax_success", success);
		}
	}
}]); 