define(
	[
	 'libs/backbone'
	],
	function (Backbone) {
		
		var teamModel = Backbone.Model.extend({
			
			defaults: {
				"location": "Town",
				"name": "Name",
				"headerBGColor": "yellow",
				"headerColor": "black"
			}
		});
		
		return teamModel;
	}
);