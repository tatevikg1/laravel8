<template>
    <header>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">   
    </header>
    <app-layout>     
           
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Approval for main profile picture.
            </h2>
        </template>
        <div class="" v-if="users">
            <ul v-for="user in users.data" :key="user.id" class="">
                <li>
                    <div class="image">
                        <img :src="user.profile_photo_url" :key="user.id"
                            class="rounded-circle" style="max-width:100px" >
                    </div>

                    <div class="info">
                        <p class='name'> {{ user.name  }} </p>
                        <p> {{ user.email }} </p>
                    </div>
    
                    <div class="info"> 
                        <Button  v-if="user.profile_photo_path && user.avatar_approved == 0" 
                            @click="approvePhoto(user.id)"> 
                            <i class="fa fa-check-circle ">approve</i>
                        </Button>
                        <Button  v-if="user.profile_photo_path && user.avatar_approved == 0" 
                            @click="deletePhoto(user.id)">
                            <i class="fa fa-minus-circle ">reject</i> 
                        </Button>        
                    </div>
                    <jet-section-border />
                </li>
            </ul>
        </div>
        <div class="p-4 flex justify-center">
            <Pagination :prev='users.prev_page_url' :next="users.next_page_url"/>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import Pagination from '@/Components/Pagination'
    import JetSectionBorder from '@/Jetstream/SectionBorder'
    import Button from '@/Jetstream/Button'
    import { Inertia } from '@inertiajs/inertia'
    import axios from 'axios'

    export default {
        props: {
            parameter:String, 
            user: Object, 
            users: Object
        },

        methods: {
            refresh(){
                Inertia.visit(this.route('admin.index'), {
                    only:['users'], 
                    // preserveState: true,
                })
            },

            approvePhoto(userId){
                axios.patch(`/admin/photo/${userId}`);
                return;
            },

            deletePhoto(userId){
                axios.delete(`/admin/photo/${userId}`);
                this.refresh();
                return;
            }
        },

        components: {
            AppLayout,
            JetSectionBorder,
            Pagination,
            Button,
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