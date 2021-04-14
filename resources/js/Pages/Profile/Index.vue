<template>
    <app-layout>
        <!-- <template #header> -->
            <div class="p-4">
                <label for="search">Search</label>
                <input type="text" id="search" v-model="term" @input="search" class="ml-2 px-2 pu-1 text-sm rounded border">
                
            </div>
        <!-- </template> -->

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <ul v-for="user in users.data" :key="user.id">
                    <hr>
                    <li>
                        <div class="image">
                            <img :src="user.profile_photo_url" :key="user.id"
                                class="rounded-circle" style="max-width:100px" >
                        </div>

                        <div class="contact">
                            <p class='name'> {{ user.name  }} </p>
                            <p> {{ user.email }} </p>
                        </div>
                        <jet-section-border />
                    </li>
                </ul>
            </div>
            <div class="p-5 flex justify-center">
                <inertia-link class="px-2" :href="users.prev_page_url" v-if="users.prev_page_url">Previous</inertia-link>
                <inertia-link class="px-2" :href="users.next_page_url" v-if="users.next_page_url">Next</inertia-link>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import JetSectionBorder from '@/Jetstream/SectionBorder'

    export default {
        props: ['parameter', 'user', 'users'],

        data(){
            return {
                term: ''
            }
        },

        methods: {
            search(){
                this.$inertia.replace(this.route('profile.index', {term: this.term}));
            }
        },

        created(){
            this.term = this.parameter;
        },

        components: {
            AppLayout,
            JetSectionBorder,
        },
    }
</script>

<style lang="scss" scoped>
li{
    display:flex;
    padding:2px;
    cursor:pointer;
    border-bottom:1px solid #d1d0d6;
    height:80px;
    position: relative;

    .image{
        flex:1;
        display:flex;
        align-items:center;

        img{
            width:50px;
            border-radius:50%;
            margin:0 auto;
        }
    }
}

.contact{
    flex:2;
    font-size:12px;
    display:flex;
    overflow:hidden;
    flex-direction:column;
    justify-content:center;

    p{
        margin:0;
    }
    .name{
        font-weight:bold;
    }
}

</style>