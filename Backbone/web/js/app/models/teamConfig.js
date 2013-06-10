define(
	[
	 'libs/backbone'
	],
	function (Backbone) {
		
		var configModel = Backbone.Model.extend({

			idAttribute: "TeamId",
			defaults: {
				"TeamConfigId": "0",
				"TeamId": "0",
				"BackColor": "yellow",
				"ForeColor": "black"
			}
		});
		
		return configModel;
	}
);