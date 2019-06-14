<template>
	<div>
		<div class="flex">
            <img class="mr-1" :src="avatar" width="50" height="50">

            <h1 v-text="user.name"></h1><small v-text="reputation"></small>

        </div>
        
        <div v-if="canUpdate">
        	<form method="POST" enctype="multipart/form-data">
	            <input type="file" name="avatar" style="margin:10px 0" @change="onChange">
	        </form>
        </div>
        
	</div>
</template>

<script>
	export default {
		props: ['user'],
		data() {
			return {
				avatar: this.user.avatar_path
			}
		},
		computed: {
			canUpdate() {
				return this.authorize(user => user.id === this.user.id);
			},
			reputation() {
				return this.user.reputation + ' XP';
			}
		}, 
		methods: {
			onChange(e) {
				if(!e.target.files.length) return;

				let file = e.target.files[0];

				let reader = new FileReader();

				reader.readAsDataURL(file);

				reader.onload = e => {
					this.avatar = e.target.result;
				}

				this.persist(file);

			},

			persist(file) {
				let data = new FormData();

				data.append('avatar', file);
				
				// flash is not working !
				axios.post(`/api/users/${this.user.name}/avatar`, data)
					.then(() => flash("Avatar Updated"));
			}
		}
		
	}
</script>