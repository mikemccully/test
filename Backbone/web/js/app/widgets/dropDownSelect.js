define(
	[
	 'libs/backbone',
	 'widgets/models/dropDownSelect'
	],
	function (Backbone, Model) {

		/**
		 * In order to add a drop down select element to a view, you must:
		 * 	- set the property name of the collection's model that will be used
		 * 		as the val property of the option element.
		 * 	- set the property name of the collection's model that will be used
		 * 		as the displayed text in the option element.
		 * 	- pass in the element (this.$el) in which the select will be 
		 * 		created. 
		 * 	- lastly, you need to set the collection which will trigger the 
		 * 		rendering.
		 */
		var SelectView = Backbone.View.extend({

			template: _.template("<select><%= options %></select>"),
			model: new Model(),

			initialize: function (attributes, options) {
				this.model.on('change:collection', this.render, this);
			},
			
			setCollection: function (collection) {
				this.model.set('collection', collection);
			},
			setIdPropertyName: function (idName) {
				this.model.set('idProperty', idName);
			},
			setLabelPropertyName: function (labelName) {
				this.model.set('labelProperty', labelName);
			},
			
			render: function () {

				/*
				 * Build the option elements to place in the select.
				 */
				this.buildOptions();

				this.$el.html(this.template(this.model.attributes));
				
				return this;
			},
			
			buildOptions: function () {
				var options = '';
				var items = this.model.get('collection');
				var that = this;
				if (items.length > 0) {
					_.each(items.models, function (item) {
						options += '<option value="'
							+ item.get(that.model.get('idProperty'))
							+ '">'
							+ item.get(that.model.get('labelProperty'))
							+ '</option>';
					});
				}
				this.model.set('options', options);
			}
		});
		
		return SelectView;
	}
);