<template>
	<div>
	    <div class="card" :id="'reply-'+ this.reply.id" :class="isBest ? 'card-success' : ''">
	        <div class="card-header"> 
	            <h5 class="level">
	                <b class="flex">
	                    <a :href="'/profile/'+ this.reply.user.name" v-text="this.reply.user.name"></a> 
	                    said <span v-text="moment(this.reply.created_at).fromNow()"></span> ...

	                </b>
	                <div v-if="signedIn">
		                <favorite :reply="reply"></favorite>                	
	                </div>

	            </h5>
	            
	        </div>

	        <div class="card-body">
	            <article>
	                <div v-if="editing">
	                    
						<wysiwyg name="body" v-model="body"></wysiwyg>
	                    <div class="form-group">
	                        <button class="btn btn-primary btn-sm" @click="update">Update</button>
	                        <button class="btn btn-link btn-sm" @click="editing = false">Cancel</button>
	                    </div>
	                </div>
	                <div v-else v-html="body"></div>
	                
	            </article>
	        </div>
	        <div class="card-footer level">
				<div v-if="authorize('updateReply', reply)">
					<button class="btn btn-sm btn-info mr-1" @click="editing = true">Edit</button>
	            	<button class="btn btn-sm btn-danger" @click="destroy">Delete</button>
				</div>
	            <button class="btn btn-sm btn-primary ml-a" @click="MarkBestReply" v-if="authorize('updateThread', reply.thread)">Best Reply ?</button>
	            
	        </div>
	    </div>
	</div>
</template>

<script>

	import favorite from './favorite.vue';
	var moment = require('moment');

	export default {
		props: ['reply'],
		components: { favorite },
		data() {
			return {

				editing: false,
				body : this.reply.body,
				moment: moment,
				isBest: this.reply.isBest,
			};
		},


		computed: {
			signedIn() {
				return window.App.signedIn;
			},
		},

		created() {
			window.events.$on('best_reply_updated', id => {
				this.isBest = (this.reply.id === id); 
			});
		},
		methods : {
			update() {
				axios.patch('/replies/' + this.reply.id, {
					body : this.body
				});

				this.editing  = false;
				flash('Successfully Updated!', 'success');
			},

			destroy(){
				axios.delete('/replies/' + this.reply.id);
				
				this.$emit('deleted', this.reply.id);

			},
			MarkBestReply() {

				this.isBest = true;

				axios.post('/replies/'+ this.reply.id +'/best');
				window.events.$emit('best_reply_updated', this.reply.id);
			}
		}
	}

</script>