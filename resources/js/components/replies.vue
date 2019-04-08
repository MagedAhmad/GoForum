<template>
	<div>
		<div v-for="(reply, index) in items">
			<reply :data="reply" @deleted="remove(index)"></reply>
		</div>

		<div>
        	<new-reply @created="add"></new-reply>
		</div>
	</div>

</template>


<script>
	import reply from './reply.vue';
	import newReply from './newReply.vue';
	
	export default {
		props: [ 'data' ],
		components: { reply, newReply },

		data() {
			return {
				items : this.data,
			}
		},

		methods: {
			remove(index) {
				this.items.splice(index,1);

				this.$emit('removed');

			},

			add(reply) {

				this.items.push(reply);
				flash('Your reply has been added!');
				this.$emit('added');


			}

		}
	}
</script>