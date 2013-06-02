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

requirejs(['router', 'views/frame'], function (router, FrameView) {
	
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

		App.frame = new FrameView();
		App.frame.render();
	};

	window.App = {};
	loadFrame();
	var app = new router();
	Backbone.history.start();
	window.onresize();
});