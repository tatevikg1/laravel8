<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                     <div style="display: flex; background-color:white; padding:15px; border-radius:5px;">

                        <Conversation :contact="selectedContact" :messages="messages" @new="saveNewMassage"/>
                        <Contacts :contacts="contacts" @selected="startConversationWith"/>

                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import Conversation from './chatcomponents/Conversation.vue'; 
    import Contacts from './chatcomponents/Contacts.vue';

    export default{

        props:{
            user:{
                require:true
            }
        },

        data(){
            return {
                selectedContact : null,
                messages: [],
                contacts: [],
                newMessageSoundUrl: 'http://codeskulptor-demos.commondatastorage.googleapis.com/descent/gotitem.mp3',
                selectContactSoundUrl : 'http://codeskulptor-demos.commondatastorage.googleapis.com/pang/pop.mp3'
            }
        },

        mounted(){

            Echo.private(`messages.${this.user.id}`)
                .listen("NewMessage", (e) => {
                    this.handleIncoming(e.message);
                });

            axios.post('/contacts')
                .then((response) =>{
                    this.contacts = response.data;
                    // this.startConversationWith(response.data[0]);
                })
                .catch(error => {
                    console.log(error.response);
                });
        },

        methods:{
            startConversationWith(contact){
                this.updateUnreadCount(contact, true);
                axios.get(`/conversation/${contact.id}`)
                    .then((response) => {
                        this.messages = response.data;
                        this.selectedContact = contact;
                    })
                this.playSound(this.selectContactSoundUrl);
            },

            saveNewMassage(message){
                this.messages.push(message);
            },

            handleIncoming(message){

                if(this.selectedContact && message.sender.id == this.selectedContact.id){
                    this.saveNewMassage(message);
                    axios.post(`/messages/${message.id}`)
                    return;
                }

                this.updateUnreadCount(message.sender, false);
                // this.playSound(this.newMessageSoundUrl);
            },

            updateUnreadCount(sender, zroyacnel){
                this.contacts = this.contacts.map((contact) =>{
                    if (contact.id != sender.id){
                        return contact;
                    }

                    if(zroyacnel)
                        contact.unread = 0;
                    else
                        contact.unread += 1;
                        console.log(contact.unread);

                    return contact;
                })
            },

            playSound(soundUrl) {
                var audio = new Audio(soundUrl);
                audio.play();
            }

        },

        components:{ Conversation, Contacts , AppLayout}
    }
</script>

