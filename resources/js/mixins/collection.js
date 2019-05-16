export default {

	methods: {
		remove(index) {
			this.items.splice(index,1);

			this.$emit('removed');

			flash('This item has been deleted', 'danger');

		},

		add(item) {

			this.items.push(item);
			flash('Your item has been added!');
			this.$emit('added');


		}	
	}
	
}
