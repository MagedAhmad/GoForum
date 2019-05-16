<template>
	<div>
	    <div class="card" :id="'reply-'+ this.data.id">
	        <div class="card-header"> 
	            <h5 class="level">
	                <b class="flex">
	                    <a :href="'/profile/'+ this.data.user.name" v-text="this.data.user.name"></a> 
	                    said <span v-text="this.data.created_at"></span> ...

	                </b>
	                <div v-if="signedIn">
		                <favorite :reply="data"></favorite>                	
	                </div>

	            </h5>
	            
	        </div>

	        <div class="card-body">
	            <article>
	                <div v-if="editing">
	                    
	                    <textarea class="form-control" v-model="body"></textarea>
	                    <div class="form-group">
	                        <button class="btn btn-primary btn-sm" @click="update">Update</button>
	                        <button class="btn btn-link btn-sm" @click="editing = false">Cancel</button>
	                    </div>
	                </div>
	                <div v-else>
	                    <p v-text="body"></p>                
	                </div>
	            </article>
	        </div>
	        <div class="card-footer level"  v-if="data.can_update">
	            <button class="btn btn-sm btn-info mr-1" @click="editing = true">Edit</button>
	            <button class="btn btn-sm btn-danger" @click="destroy">Delete</button>
	            
	        </div>
	    </div>
	</div>
</template>

<script>

	import favorite from './favorite.vue';

	export default {
		props: ['data'],
		components: { favorite },
		data() {
			return {
				editing: false,
				body : this.data.body,
			};
		},

		computed: {
			signedIn() {
				return window.App.signedIn;
			},

			
		},
		methods : {
			update() {
				axios.patch('/replies/' + this.data.id, {
					body : this.body
				});

				this.editing  = false;
				flash('Successfully Updated!', 'success');
			},

			destroy(){
				axios.delete('/replies/' + this.data.id);

				this.$emit('deleted', this.data.id);

			}
		}
	}

</script>