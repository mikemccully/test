define(
	[
	 'libs/backbone',
	 'models/team'
	],
	function (Backbone, TeamModel) {
		
		var NavModel = Backbone.Model.extend({
			
			defaults: {
				"team": new TeamModel()
			}
		});
		
		return NavModel;
	}
);