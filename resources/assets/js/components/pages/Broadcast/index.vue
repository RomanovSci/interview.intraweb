<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1>Broadcast</h1>
                <p>Send message to all subscribers.</p>
                <p>You can select subscribers and send message to each of them on <a href="/">subscribers page</a></p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <form class="text-center">
                    <input
                        v-model="message"
                        placeholder="Type message here..."
                    >
                    <input
                        class="btn btn-success"
                        type="button"
                        value="Send to all"
                        @click="sendMessage"
                    >
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        data() {
            return {message: ''}
        },

        methods: {
            sendMessage() {

                if (!this.message) {
                    console.error("message can't be blank");
                    return;
                }

                axios
                    .post('/bot/broadcast', {message: this.message})
                    .then(() => {this.message = null;});
            }
        }
    }
</script>