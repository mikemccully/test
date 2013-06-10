define(
	[
	 'libs/backbone',
	 'models/team'
	],
	function (Backbone, TeamModel) {
		
		var NavModel = Backbone.Model.extend({

			defaults: {
				"teamSelect": {} // This is for the dropDownSelect view.
			}
		});
		
		return NavModel;
	}
);