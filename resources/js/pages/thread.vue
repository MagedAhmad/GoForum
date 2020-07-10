<script>
	import replies from '../components/replies.vue';
	import subscripeButton from '../components/subscripeButton.vue';


	export default {
		props: ['thread'],
		components: { replies, subscripeButton },
		data() {
			return {
				repliesCount : this.thread.replies_count,
				locked : this.thread.lock,
				editing: false,
				form: {
					title: this.thread.title,
					body: this.thread.body
				},
				title: this.thread.title,
				body: this.thread.body,
			}
		},
		computed: {
			signedIn() {
				return window.App.signedIn;
			}
		},

		methods: {
			toggleLock() {
				axios.post('/lock-threads/' + this.thread.slug, {
                    _method: this.locked ? 'delete' : 'post'
				})

				this.locked = !this.locked;
			},
			update() {
				let uri = `/threads/${this.thread.channel.id}/${this.thread.slug}`;

				axios.post(uri, {
					title: this.form.title,
					body: this.form.body, 
					_method: 'patch'
					}).then(() => {
					this.editing = false;
					this.title = this.form.title;
					this.body = this.form.body;

					flash('Your thread has been updated.');
				});
			},
			reset() {
				this.form = {
					title: this.thread.title,
					body: this.thread.body,
				};

				this.editing = false;
			}
		},

	}
</script>