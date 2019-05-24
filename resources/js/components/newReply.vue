<template>
	<div>
		<div v-if="signedIn">
			<div class="form-group">
                <textarea class="form-control" name="body" id="body" rows="5" placeholder="Have something to say?" v-model="body"></textarea>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" @click="add" name="submit" value="Submit">
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
				reply: '',
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