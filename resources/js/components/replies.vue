<template>
	<div>
		<div v-for="(reply, index) in items">
			<reply :data="reply" @deleted="remove(index)" :key="reply.id"></reply>
		</div>

		<paginator @changed="fetch" :dataSet="dataSet"></paginator>

		<div>
        	<new-reply @created="add"></new-reply>
		</div>
	</div>

</template>


<script>
	import reply from './reply.vue';
	import newReply from './newReply.vue';
	import collection from '../mixins/collection';
	
	export default {
		components: { reply, newReply },
		mixins : [ collection],
		data() {
			return {
				dataSet: false,
				items : [],
			}
		},

		created(){
			this.fetch();
		},

		methods: {

			fetch(page){
				axios.get(this.url(page))
					.then(this.refresh)
			},

			url(page = 1) {
				return location.pathname + '/replies?page=' + page;
			},

			refresh({data}) {
				this.dataSet = data;
				this.items = data.data;
			},


		}
	}
</script>