define(
	[
	 'libs/backbone',
	 'views/frame'
	],
	function (Backbone, FrameView) {

		var AppRouter = Backbone.Router.extend({

			initialize: function () {
			},

			routes: {
				"test": "loadAnotherView"
			},
			
			loadAnotherView: function () {
				console.log('You are in another view');
			}
		});
		
		return AppRouter;
	}
);