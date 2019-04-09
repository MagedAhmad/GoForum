export default {

	methods: {
		remove(index) {
			this.items.splice(index,1);

			this.$emit('removed');

		},

		add(item) {

			this.items.push(item);
			flash('Your item has been added!');
			this.$emit('added');


		}	
	}
	
}
