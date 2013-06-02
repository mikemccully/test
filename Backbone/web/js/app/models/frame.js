define(
	[
	 'libs/backbone',
	 'collections/teams',
	 'models/team',
	 'collections/teamConfigs'
	],
	function (Backbone, TeamCollection, TeamModel, ConfigCollection) {
		
		var FrameModel = Backbone.Model.extend({
			
			defaults: {
				"team": new TeamModel(),
				"teams": new TeamCollection(),
				"teamConfigs": new ConfigCollection()
			},
			
			initialize: function (attributes, options) {
				this.get('teams').fetch();
				this.get('teamConfigs').fetch();
			}
		});
		
		return FrameModel;
	}
);