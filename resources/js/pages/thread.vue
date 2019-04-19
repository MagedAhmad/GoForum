<script>
	import replies from '../components/replies.vue';
	import subscripeButton from '../components/subscripeButton.vue';


	export default {
		props: ['initialRepliesCount'],
		components: { replies, subscripeButton },
		data() {
			return {
				repliesCount : this.initialRepliesCount,
			}
		},

	}
</script>