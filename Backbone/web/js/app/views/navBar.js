define(
	[
	 'libs/backbone',
	 'models/navBar',
	 'libs/text!templates/navBar.html'
	],
	function (Backbone, NavBarModel, tpl) {
		
		var NavView = Backbone.View.extend({
			
			template: _.template(tpl),
			model: new NavBarModel(),

			initialize: function (attributes, options) {
				this.model.on('change:team', this.setBackgroundColor, this);
				this.model.on('change:teams', this.render, this);
			},
			
			render: function () {

				/*
				 * Build the option elements to place in the select.
				 */
				this.buildTeamOptions();
				
				this.$el.html(this.template(this.model.attributes));
				this.setBackgroundColor(this.model);
				
				return this;
			},
			
			setBackgroundColor: function (model) {
				var team = model.get('team');
				var cssConfig = {
						"background-color": team.get('headerBGColor'),
						"color": team.get('headerColor')
				}
				this.$el.css(cssConfig);
			},
			
			buildTeamOptions: function () {
				var options = '';
				var teams = this.model.get('teams');
				if (teams.length > 0) {
					_.each(teams.models, function (team) {
						options += '<option>' + team.get('TeamName') + '</option>';
					});
				}
				this.model.set('teamOptions', options);
			}
		});
		
		return NavView;
	}
);