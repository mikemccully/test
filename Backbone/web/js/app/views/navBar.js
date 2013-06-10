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
			dispatcher: {},

			initialize: function (attributes, options) {

				this.dispatcher = attributes.dispatcher;

				this.dispatcher.on('teamChanged', this.setBackgroundColor, this);
				this.dispatcher.on('teamsLoaded', this.setTeamsCollectionInSelect, this);

				/*
				 * Create the widget for the team select.
				 */
				var selectView = new SelectWidget();
				selectView.setIdPropertyName('TeamId');
				selectView.setLabelPropertyName('TeamName');
				this.model.set('teamSelect', selectView);
				selectView.model.on('change:selected', this.handler_selectedTeamChanged, this);
				
				this.render();
			},

			render: function () {

				this.$el.html(this.template(this.model.attributes));
				this.setBackgroundColor(App.frame.model);

				/*
				 * We need to add the $el attribute at this point because we 
				 * had to wait until the template was rendered.
				 */
				this.model.get('teamSelect').$el = this.$('.selectContainer');
				
				return this;
			},

			setTeamsCollectionInSelect: function (teams) {

				var selectEl = this.model.get('teamSelect');
				selectEl.setCollection( teams );
				/*
				 * This is needed to trigger a change that will set the 
				 * properties of the first element in the set.
				 */
				selectEl.$('select').trigger('change');
			},

			setBackgroundColor: function (team) {

				var cssConfig = {
						"background-color": team.get('BackColor'),
						"color": team.get('ForeColor')
				}
				this.$el.css(cssConfig);
			},

			handler_selectedTeamChanged: function (model) {

				this.dispatcher.trigger('teamUpdate', model.get('selected'));
			} 
		});
		
		return NavView;
	}
);