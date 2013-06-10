define(
	[
	 'libs/backbone',
	 'models/header',
	 'libs/text!templates/header.html'
	],
	function (Backbone, HeaderModel, tpl) {
		
		var headerView = Backbone.View.extend({
			
			template: _.template(tpl),
			model: new HeaderModel(),
			dispatcher: {},

			initialize: function (attributes, options) {

				this.dispatcher = attributes.dispatcher;

				// Listen for any changes to the global team.
				this.dispatcher.on('teamChanged', this.handler_teamChange, this);
				// Listen for changes to the local model.
				this.model.on('change', this.render, this);
			},
			
			render: function () {

				this.$el.html(this.template(this.model.attributes));
				this.setBackgroundColor(App.frame.model);
				return this;
			},

			setTeamValues: function (team) {

				this.model.set({
					'teamLocation': team.get('AreaName'),
					'teamName': team.get('TeamName')
				});
			},

			setBackgroundColor: function (team) {

				var cssConfig = {
						"background-color": team.get('BackColor'),
						"color": team.get('ForeColor')
				}
				this.$el.css(cssConfig);
			},

			handler_teamChange: function (team) {

				this.setTeamValues(team);
				this.setBackgroundColor(team);
			}
		});
		
		return headerView;
	}
);