<template>
    <div>
        <div class="level flex justify-center md:justify-start">
            <label for="file-input">
				<img class="mx-4 w-20 h-20 object-cover rounded-full sm:block" :src="avatar" width="100" height="100" />
			</label>

            <h1 class="flex flex-col font-bold">
                {{ user.name }}
                <small class="text-red-500" v-text="reputation"></small>
                <a :href="update_user_path" class="hover:bg-gray-800 hover:no-underline bg-gray-500 rounded p-1 text-white mt-3" v-if="canUpdate">
                    <i class="fa fa-cog"></i> 
                    Update profile
                </a>
                <a class="hover:bg-gray-800 hover:no-underline bg-gray-500 rounded p-1 text-white mt-3" v-if="!canUpdate" :href="chat_path">
                    <i class="fa fa-envelope"></i>
                    Chat
                </a>
            </h1>
        </div>

        <form v-if="canUpdate" method="POST" enctype="multipart/form-data">
			<div>
				<input id="file-input" class="hidden" type="file" accept="image/*" @change="onChange">
			</div>
		</form>

    </div>
</template>

<script>
    export default {
        props: ['user'],
        data() {
            return {
                avatar: this.user.avatar_path,
                update_user_path: '/profiles/' + this.user.name + '/update',
                chat_path: "/chats/" + this.user.name
            };
        },

        computed: {
            canUpdate() {
                return this.authorize(user => user.id === this.user.id);
            },

            reputation() {
                return this.user.reputation + 'XP';
            }
        },

        methods: {
            persist(avatar) {
                let data = new FormData();
                data.append('avatar', avatar);
                axios.post(`/api/users/${this.user.username}/avatar`, data)
                    .then(() => flash('Avatar uploaded!'));
			},
			onChange(e) {
                if (e.target.files.length == 0) return;

                let file = e.target.files[0];
                let reader = new FileReader();

                reader.readAsDataURL(file);

                reader.onload = e => {
					let src = e.target.result;
					this.avatar = src;
					this.persist(file);
                };
            }
        }
    }
</script>
