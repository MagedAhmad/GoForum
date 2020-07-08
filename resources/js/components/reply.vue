<template>
	<div class="py-2">
	    <div class="p-3 shadow" :id="'reply-'+ this.reply.id" :class="isBest ? 'border-solid border-2 border-green-500 bg-white' : 'bg-white'">
	        <div> 
	            <h5 class="">
	                <b class="flex justify-between">
						
						<div class="flex flex-col items-center justify-between">
							<a class="text-lg font-semibold text-gray-900 -mt-1" :href="'/profile/'+ this.reply.user.name" v-text="this.reply.user.name"></a>
							<small class="text-sm text-gray-700" v-text="moment(this.reply.created_at).fromNow()"></small>
						</div>
						<div class="flex items-center">
							<div v-if="signedIn">
								<favorite :reply="reply"></favorite>                	
							</div>
							<span v-if="isBest" class="tracking-wider text-white bg-green-500 px-4 py-1 text-sm rounded leading-loose mx-2 font-semibold" title="">
								<i class="fa fa-star" aria-hidden="true"></i> Best Reply
							</span>
						</div>
	                </b>
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
	        <div class="level">
				<div v-if="authorize('updateReply', reply)">
					<button class="btn btn-sm btn-info mr-1" @click="editing = true">Edit</button>
	            	<button class="btn btn-sm btn-danger" @click="destroy">Delete</button>
				</div>	 
				<button class="" @click="MarkBestReply" v-if="authorize('updateThread', reply.thread) && !isBest">Best Reply ?</button>

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
				axios.post('/replies/' + this.reply.id, {
					body : this.body,
                    _method: 'patch'
				}).then((response) => {
					flash('Successfully Updated!', 'success');
				}).catch((err) => {
					console.log(err)
				})

				this.editing  = false;
			},

			destroy(){
				axios.post('/replies/' + this.reply.id, {
                      _method: 'delete'
                    })
					.then((response) => {
						flash('Successfully Deleted!', 'success');
					}).catch((err) => {
						console.log(err)
					})
				
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