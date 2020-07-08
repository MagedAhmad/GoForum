<template>
	<a class="flex mr-2" :class="classes" @click="toggle">
		<span class="oi oi-thumb-up" :class="classes"></span>
        <p v-text="count"></p>
    </a>	
	
</template>


<script>
	export default {
		props: ['reply'],

		data() {
			return {
				count: this.reply.favoritesCount,
				active: this.reply.isFavorited,
			}
		},

		computed: {
			classes() {
				return [(this.active) ? 'text-green-500' : 'text-gray-500']; 
			}
		},

		methods: {
			toggle() {
				(this.active) ? this.destroy() : this.create();
			},

			destroy() {
				axios.delete('/replies/' + this.reply.id + '/favorites');
				this.count -- ;
				this.active = false;
			},

			create() {
				axios.post('/replies/' + this.reply.id + '/favorites');
				this.count ++ ;
				this.active = true;

			}
		}
	}
</script>