define(
	[
	 'libs/backbone',
	 'models/team'
	],
	function (Backbone, TeamModel) {
		
		var FrameModel = Backbone.Model.extend({
			
			defaults: {
				"team": new TeamModel()
			}
		});
		
		return FrameModel;
	}
);