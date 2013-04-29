define(
	[
	 'libs/backbone'
	],
	function (Backbone) 
	{

		var NavModel = Backbone.Model.extend({

			defaults: {
				"collection": {},
				"idProperty": "id",
				"labelProperty": "name",
				"options": '',
				"selected": {}
			}
		});

		return NavModel;
	}
);