<template>
	<div>
		<div v-if="signedIn">
			<div class="form-group">
				<wysiwyg name="body" v-model="body" placeholder="Have something to say?"></wysiwyg>
			</div>
            <div class="form-group">
                <input type="submit" class="mt-6 mb-12 md:mb-0 md:mt-10 inline-block py-2 px-8 text-white bg-red-500 hover:bg-red-600 rounded-lg shadow" @click="add" name="submit" value="Add Reply">
            </div>
		</div>
	    <div v-else>
	    	<p class="text-center">Please <a  href="/login">SIGN IN</a> to participate in this forum!</p>
	    </div>  
	</div>
	
</template>


<script>
	
	import 'jquery.caret';
	import 'at.js';

	export default {
		data() {
			return {
				body : '',
				endpoint: window.location.pathname + '/replies',
			}
		},

		mounted() {
			$('#body').atwho({
				at: "@",
				delay: 750,
				callbacks: {
					remoteFilter: function(query, callback) {
						$.getJSON("/api/users", {name, query}, function(usernames) {
							callback(usernames);
						});
					}
				}
			});
		},

		computed: {
			signedIn() {
				return window.App.signedIn;
			}
		},

		methods: {

			add() {
				axios.post(this.endpoint, {body: this.body})
					.catch(error  => {
						flash(error.response.data, "danger");
					})
					.then(({data}) => {
						this.body = '';
						this.$emit('created', data);
						flash('Reply posted!', "success");

					});

			}
		},
	}

</script>