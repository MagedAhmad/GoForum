<template>
    <button :class="classes" @click="subscripe">Subscribe</button>
	
</template>



<script>

	export default {

		props: ['active'],
		computed: {
			classes() {
				return (this.active) ? 'btn btn-success' : 'btn btn-default'; 
			}
		},
		methods: {
			subscripe() {
				let requestType = this.active ? 'delete' : 'post';
				axios[requestType](location.pathname + '/subscriptions');
				this.active = ! this.active;
			}
		}
	}

</script>