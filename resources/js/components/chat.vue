<template>
    <div class="mx-auto container my-4">
        <div class="card bg-gray-100 rounded">
            <div class="header bg-gray-500 rounded p-2 flex items-center">
                <img class="w-6 h-6" :src="recipient.avatar_path" alt="avatar">
                <span class="mx-2 text-white" v-text="recipient.name"></span>
                <i :class="onlineIcon"></i>
            </div>
            <div class="card-body border border-1 relative">
                <ul class="list-unstyled" style="height:300px; overflow-y:scroll" v-chat-scroll>
                    <li v-for="(message, index) in messages" :key="index">
                        <div class="flex">
                            <img :src="message.user.avatar_path" class="w-6 h-6" alt="avatar">
                            <span v-text="message.user.name"></span>
                        </div>
                        <p v-text="message.body"></p>
                    </li>
                </ul>
                <span class="text-gray-600" v-show="typing" v-text="recipient.name + ' is typing'"></span>
            </div>
            <div class="footer">
                <input 
                    @keydown="sendTypingEvent" 
                    v-model="newMessage"
                    @keyup.enter="sendMessage" 
                    type="text" 
                    class="form-control" 
                    placeholder="Enter your message">
            </div>
        </div>
    </div>

</template>

<script>
export default {
    props: ['recipient', 'sender'],
    data() {
        return {
            messages: '',
            newMessage: '',
            users: [],
            onlineIcon: 'fa fa-circle text-green-500',
            typing: false,
            typingTimer: false,

        }
    },
    // computed: {
    //     onlineIcon() {
    //         return this.users.length > 1 ?  'fa fa-circle text-green-500' : 'fa fa-circle text-red-500';
    //     }
    // },
    created() {
        this.getMessages()
        Echo.join('chat')
            .listen('MessageSent',(event) => {
                if(event.user.name == window.App.user.name){
                    this.messages.push(event.message)
                }
            })
            .listenForWhisper('typing', (response) => {
                if(response.name != window.App.user.name){
                    return;
                }
                this.typing = true

                if(this.typingTimer) {
                    clearTimeout(this.typingTimer);
                }
                this.typingTimer = setTimeout(() => {
                    this.typing = false;
                }, 3000);
            })
    },
    methods: {
        getMessages() {
            axios.get('/chats/' + this.recipient.name + '/messages')
                .then((response) => {
                    this.messages = response.data
                }).catch((error) => {
                    console.log(error)
                })
        },
        sendMessage(){
            axios.post('/chats', {
                    body: this.newMessage,
                    to: this.recipient.id
                })
                .then(() => {
                    this.messages.push({
                        user: this.sender,
                        body: this.newMessage
                    })
                    this.newMessage = ''
                })
        },
        sendTypingEvent() {
            Echo.join('chat')
                .whisper('typing', this.recipient)
        }
    }
}



</script>

<style>

</style>