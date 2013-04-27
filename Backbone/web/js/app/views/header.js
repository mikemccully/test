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
				this.model.on('change:team', this.render, this);
				this.model.on('change:team', this.setBackgroundColor, this);
			},
			
			render: function () {
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
			}
		});
		
		return headerView;
	}
);