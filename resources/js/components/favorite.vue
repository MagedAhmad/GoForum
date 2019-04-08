<template>
	<button :class="classes" @click="toggle">
		<span class="oi oi-thumb-up"></span>
        <p style="padding-top:20px;" v-text="count"></p>
    </button>	
	
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
				return ['level' ,'btn' , (this.active) ? 'btn-primary' : 'btn-default']; 
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