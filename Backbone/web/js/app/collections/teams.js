define(
	[
	 'libs/backbone',
	 'models/team'
	],
	function (Backbone, TeamModel) {
		
		var TeamsCollection = Backbone.Collection.extend({

			model: TeamModel,
			url: 'index.php?module=teamData&controller=team&raw=',
		});
		
		return TeamsCollection;
	}
);