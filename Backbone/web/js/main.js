requirejs.config({
	baseUrl: './js/app',
	paths: {
		libs: '../libs'
	},
	shim: {
		'libs/backbone': {
			deps: ['libs/underscore', 'libs/jquery'],
			exports: 'Backbone'
		},
		'libs/underscore': {
			exports: '_'
		}
	}
});

requirejs(['libs/backbone', 'views/frame'], function (Backbone, FrameView) {

	var dispatcher = _.extend( {}, Backbone.Events );
	window.App = {};

	window.onresize = function () {

		var headerHt = $('#headerContainer').outerHeight();
		var navHt = $('#navContainer').outerHeight();
		var footHt = $('#footerContainer').outerHeight();
		var windowHt = window.innerHeight;
		var contentHt = windowHt - (navHt + headerHt + footHt + 14);
		$('#contentContainer').innerHeight(contentHt);
	};

	/**
	 * Initialize and render the page frame.
	 */
	var loadFrame = function () {

		App.frame = new FrameView( {dispatcher: dispatcher} );
		App.frame.render();
	};

	loadFrame();
	Backbone.history.start();
	window.onresize();
});