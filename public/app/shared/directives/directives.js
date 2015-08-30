'use strict';

/* Directives */

angular.module("Bootstrap.directives", [])
	.directive('ishuman', [function() {
		return {
			restrict: 'E',
			replace: 'true',
			templateUrl: '/app/shared/partials/is_human.html',
			link: function(scope, el, attrs) {

				scope.newRandom = function() {
					scope.randomNum = Math.floor((Math.random() * 10) + 1);
				}
				
				scope.newRandom();
				el = $(el[0]);
				var slider = el.find('.human-slider');
				slider.slider({
					range: true,
					min: 0,
					max: 10,
					step: 1,
					slide: function(e,ui) {
						$(".slider-value").html(ui.value);
						scope.sliderValue = ui.value;
					}
				});
				

			}
		};
	}]);