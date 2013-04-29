define(
	[
	 'libs/backbone'
	],
	function (Backbone) {
		
		var teamModel = Backbone.Model.extend({
			
			defaults: {
				"TeamId": "0",
				"City": "Town",
				"State": "Anywhere",
				"TeamName": "Name",
				"AreaName": "Name",
				"BackColor": "yellow",
				"ForeColor": "black"
			}
		});
		
		return teamModel;
	}
);