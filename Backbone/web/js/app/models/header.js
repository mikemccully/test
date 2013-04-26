define(
	[
	 'libs/backbone',
	 'models/team'
	],
	function (Backbone, TeamModel) {
		
		var headerModel = Backbone.Model.extend({
			
			defaults: {
				"title": "My Backbone Project",
				"team": new TeamModel()
			}
		});
		
		return headerModel;
	}
);