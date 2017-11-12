<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1>Telegram subscribers [{{subscribers.length}}]</h1>
                <p>List of people what subscribed to your channel. You can send message to all subscribers on <router-link to="/broadcast">broadcast</router-link> page</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 col-md-offset-4 text-center">
                <paginate name="subscribers" :list="subscribers" :per="5">
                    <li v-for="subscriber in paginated('subscribers')" class="list-group-item">
                        <input type="checkbox" v-model="subscriber.isSelected">
                        {{ subscriber.telegram_username }}
                        [{{ subscriber.id }}]
                    </li>
                </paginate>
                <paginate-links
                    for="subscribers"
                    :show-step-links="true"
                ></paginate-links>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 text-center">
                <input
                    class="btn btn-default"
                    type="button"
                    value="Send message to selected"
                    @click="openMessageForm"
                >
                <input
                    class="btn btn-danger"
                    type="button"
                    value="Delete selected"
                    @click="deleteSelected"
                >
            </div>
            <div class="col-md-12 text-center">
                <div v-if="messageFieldIsOpen">
                    <input
                        placeholder="Type message here..."
                        v-model="message"
                    >
                    <input
                        class="btn btn-success"
                        type="button"
                        value="Send"
                        @click="sendToSelected"
                    >
                </div>
            </div>
        </div>
    </div>
</template>

<style>
    .paginate-links li {
        display: inline-block;
        position: relative;
        padding: 10px 15px;
        margin-bottom: -1px;
        background-color: #fff;
        border: 1px solid #d3e0e9;
    }

    .paginate-links li.disabled{
        background-color: #eaeaea;
    }

    .paginate-links li.active{
        background-color: #abe4ff;;
    }

    .paginate-links li a{
        cursor: pointer;
        color: #7b8285;
    }
</style>

<script>
    import axios from 'axios';

    export default {
        data() {
            return {
                subscribers: [],
                paginate: ['subscribers'],

                messageFieldIsOpen: false,
                message: null,
            };
        },

        /**
         * Get all subscribers
         * @return void
         */
        mounted() {
            axios.get('subscribers')
                .then(({data}) => {
                    data.forEach((subscriberData) => {
                        subscriberData.isSelected = false;
                        this.subscribers.push(subscriberData);
                    });
                });
        },

        methods: {

            /**
             * Open form for sending message
             * @return void
             */
            openMessageForm() {
                let selected = this.subscribers.filter((subscriber) => {
                    return subscriber.isSelected;
                });

                this.messageFieldIsOpen = selected.length;
            },

            /**
             * Send message to selected users
             * @return void
             */
            sendToSelected() {
                let ids = [];

                this.subscribers.forEach(subscriber => {
                    if (subscriber.isSelected) {
                        ids.push(subscriber.id);
                    }
                });

                if (!ids.length || !this.message) {
                    return;
                }

                axios.post('/bot/broadcast', {
                    ids: ids,
                    message: this.message
                })
                    .then(() => {
                        this.message = null;
                    })
            },

            /**
             * Delete selected users
             * @return void
             */
            deleteSelected() {
                this.subscribers.forEach(subscriber => {

                    if (!subscriber.isSelected) {
                        return;
                    }

                    axios.delete(`/subscriber/${subscriber.id}`)
                        .then(({data}) => {

                            if (data.hasOwnProperty('success') && data.success) {
                                this.subscribers = _.filter(this.subscribers, (current) => {
                                    return current.id != data.id
                                });
                            }
                        });
                });
            }
        }
    }
</script>