define(
	[
	 'libs/backbone',
	 'libs/text!templates/frame.html',
	 'models/frame',
	 'views/header',
	 'views/navBar'
	],
	function (Backbone, frameTpl, FrameModel, HeaderView, NavBarView) {

		var FrameView = Backbone.View.extend({

			el: 'body',
			template: _.template(frameTpl),
			model: new FrameModel(),
			headerView: {},
			navBarView: {},
			dispatcher: {},

			initialize: function (attributes, options) {

				this.dispatcher = attributes.dispatcher;

				/*
				 * The frame model's 'team' and 'teams' attributes are used by
				 * many objecs in the application. An object must listen to the
				 * dispatcher in order to react to changes in these values.
				 */
				// Fired once when all teams have been loaded.
				this.model.get('teams').once('add', this.handler_teamsLoaded, this);
				// Fired with every team change.
				this.dispatcher.on('teamUpdate', this.handler_teamChange, this);
			},

			render: function () {

				this.$el.html(this.template());

				this.headerView = new HeaderView({el:this.$('#headerContainer'), dispatcher:this.dispatcher});

				this.navBarView = new NavBarView({el:this.$('#navContainer'), dispatcher:this.dispatcher});

				return this;
			},

			handler_teamsLoaded: function (model) {

				this.dispatcher.trigger('teamsLoaded', this.model.get('teams'));
			},

			handler_teamChange: function (team) {

				this.model.set('team', team);
				this.dispatcher.trigger('teamChanged', team);
			}
		});

		return FrameView;
	}
);