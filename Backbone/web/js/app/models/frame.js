define(
	[
	 'libs/backbone',
	 'collections/teams',
	 'models/team'
	],
	function (Backbone, TeamCollection, TeamModel) {
		
		var FrameModel = Backbone.Model.extend({
			
			defaults: {
				"team": new TeamModel(),
				"teams": new TeamCollection()
			},
			
			initialize: function (attributes, options) {
				this.get('teams').fetch();
			}
		});
		
		return FrameModel;
	}
);