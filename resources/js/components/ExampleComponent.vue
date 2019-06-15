<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Anonymous Chat</div>
                    <div class="card-body">
                        <ul class="chat">
                            <li v-for="conversation in conversations">
                                <!-- <span class="chat-img pull-left">
                                    <img src="http://placehold.it/50/55C1E7/fff&text=U" alt="User Avatar" class="img-circle" />
                                </span> -->
                                <div class="alert alert-primary" role="alert">
                                        <strong>{{conversation.user}}</strong> - {{conversation.message}}
                                </div>
                            </li>
                        </ul>
                    </div>
                     <div class="card-footer">
                            <div class="input-group-append">

                            </div>
                        <div class="input-group">
                            <input id="btn-input" type="text" class="form-control input-sm" placeholder="Type your message here..." v-model="message" @keyup.enter="store()" autofocus/>
                            <div class="input-group-append">
                                <span class="input-group-text" id="btn-chat" @click.prevent="store()">
                                    Send
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                conversations: [],
                message: ''
            }
        },
        mounted() {
            this.getConversations();
            this.listen();
        },

        methods: {
            store() {
                axios.post('/api/conversations/store', {
                    message: this.message
                }).then((response) => {
                    this.message = '';
                    this.conversations.push(response.data);
                });
            },

            getConversations() {
                axios.get('/api/conversations', {}).then((response) => {
                    this.conversations = response.data;
                });
            },

            listen() {
                Echo.channel('public-chat').listen('NewMessage', (e) => {
                    this.conversations.push(e.conversations);
                })
            }
        }
    }
</script>
