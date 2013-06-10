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

			initialize: function (attributes, options) {
				App.frame.model.on('change:team', this.render, this);
				App.frame.model.on('change:team', this.setBackgroundColor, this);
			},
			
			render: function () {
				this.$el.html(this.template(this.model.attributes));
				this.setBackgroundColor(App.frame.model);
				return this;
			},
			
			setBackgroundColor: function (model) {
				var team = model.get('team');
				var cssConfig = {
						"background-color": team.get('BackColor'),
						"color": team.get('ForeColor')
				}
				this.$el.css(cssConfig);
			}
		});
		
		return headerView;
	}
);