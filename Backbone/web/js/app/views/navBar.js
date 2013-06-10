define(
	[
	 'libs/backbone',
	 'models/navBar',
	 'libs/text!templates/navBar.html',
	 'widgets/dropDownSelect'
	],
	function (Backbone, NavBarModel, tpl, SelectWidget) {
		
		var NavView = Backbone.View.extend({
			
			template: _.template(tpl),
			model: new NavBarModel(),

			initialize: function (attributes, options) {
				
				App.frame.model.on('change:team', this.setBackgroundColor, this);
				this.on('teamsLoaded', this.render, this);

				/*
				 * Create the widget for the team select.
				 */
				var selectView = new SelectWidget();
				selectView.setIdPropertyName('TeamId');
				selectView.setLabelPropertyName('TeamName');
				this.model.set('teamSelect', selectView);
				selectView.model.on('change:selected', this.handler_selectedTeamChanged, this);
			},

			render: function () {

				this.$el.html(this.template(this.model.attributes));
				this.setBackgroundColor(App.frame.model);

				/*
				 * We need to add the $el attribute at this point because we 
				 * had to wait until the template was rendered.
				 */
				this.model.get('teamSelect').$el = this.$('.selectContainer');
				this.model.get('teamSelect').setCollection(App.frame.model.get('teams'));
				
				return this;
			},
			
			setBackgroundColor: function (model) {
				var team = model.get('team');
				var cssConfig = {
						"background-color": team.get('BackColor'),
						"color": team.get('ForeColor')
				}
				this.$el.css(cssConfig);
			},

			triggerFirstTeam: function () {
				this.model.get('teamSelect').$('select').trigger('change');
			},

			handler_selectedTeamChanged: function (model) {
				this.trigger('teamUpdate', model.get('selected'));
			} 
		});
		
		return NavView;
	}
);