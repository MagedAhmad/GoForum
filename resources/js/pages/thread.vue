<script>
	import replies from '../components/replies.vue';
	
	export default {
		props: ['initialRepliesCount'],
		components: { replies },
		data() {
			return {
				repliesCount : this.initialRepliesCount,
			}
		},

	}
</script>