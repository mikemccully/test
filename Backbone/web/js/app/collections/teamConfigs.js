define(
	[
	 'libs/backbone',
	 'models/teamConfig'
	],
	function (Backbone, ConfigModel) {
		
		var ConfigsCollection = Backbone.Collection.extend({

			model: ConfigModel,
			url: 'index.php?module=teamData&controller=teamConfig&raw=',
		});
		
		return ConfigsCollection;
	}
);