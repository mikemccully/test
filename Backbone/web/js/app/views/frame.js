define(
	[
	 'libs/backbone',
	 'libs/text!templates/frame.html',
	 'models/header',
	 'views/header'
	],
	function (Backbone, frameTpl, HeaderModel, HeaderView) {

		var FrameView = Backbone.View.extend({

			el: 'body',
			template: _.template(frameTpl),
			headerView: null,
			
			render: function () {
				this.$el.html(this.template());

				var headerModel = new HeaderModel();
				var headerAttr = {
						el: this.$('#headerContainer'),
						model: headerModel
				};
				this.headerView = new HeaderView(headerAttr);
				this.headerView.render();

				return this;
			}
		});
		
		return FrameView;
	}
);