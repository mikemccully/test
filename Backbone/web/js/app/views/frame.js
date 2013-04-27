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

			initialize: function (attributes, options) {

				this.model.on('change:team', this.handler_teamChange, this);
				this.model.get('teams').on('add', this.handler_teamsLoaded, this);
			},

			render: function () {

				this.$el.html(this.template());

				this.headerView = new HeaderView({el:this.$('#headerContainer')});
				this.headerView.render();

				this.navBarView = new NavBarView({el:this.$('#navContainer')});
				this.navBarView.render();

				return this;
			},

			handler_teamsLoaded: function (model) {

				this.navBarView.model.set('teams', this.model.get('teams'));
			},

			handler_teamChange: function (model) {

				var team = model.get('team');
				this.headerView.model.set('team', team);
				this.navBarView.model.set('team', team);
			}
		});

		return FrameView;
	}
);