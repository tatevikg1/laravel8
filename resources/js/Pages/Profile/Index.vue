<template>
    <app-layout>        
        <template #header>
            <div class="search">
                <label for="search">Search</label>
                <input type="text" id="search" v-model="term" @input="search" class="ml-2 px-2 pu-1 text-sm rounded border"> 
            </div>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8" v-if="users" >
                <ul v-for="user in users.data" :key="user.id">
                    <li @click="visitUser(user.id)">
                        <div class="image">
                            <img :src="user.profile_photo_url" :key="user.id"
                                class="rounded-circle" style="max-width:100px" >
                        </div>

                        <div class="info">
                            <p class='name'> {{ user.name  }} </p>
                            <p> {{ user.email }} </p>
                        </div>
                        <jet-section-border />
                    </li>
                </ul>
            </div>
            <div class="p-4 flex justify-center">
                <Pagination :prev='users.prev_page_url' :next="users.next_page_url"/>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import Pagination from '@/Components/Pagination'
    import JetSectionBorder from '@/Jetstream/SectionBorder'
    import { Inertia } from '@inertiajs/inertia'

    export default {
        props: {
            parameter:String, 
            user: Object, 
            users: Object
        },

        data(){
            return {
                term: ''
            }
        },

        methods: {
            search(){
                Inertia.visit(this.route('profile.index', {term:this.term}), {
                    only:['users'], 
                    preserveState: true,
                })
            },

            visitUser(userId){
                Inertia.get(this.route('profile.show', userId ) );
            },
        },

        created(){
            this.term = this.parameter;
        },

        components: {
            AppLayout,
            JetSectionBorder,
            Pagination,
        },
    }
</script>

<style lang="scss" scoped>     
.search{
    display: inline-block;
    position: relative;
    left: 40%;
    transform: translateX(-50%);
    padding-top:0;
}

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

    .info{
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
}


</style>