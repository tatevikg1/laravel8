<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ profile.name }}
      </h2>
    </template>

    <div class="container">
        <div class="grid grid-rows-3 grid-flow-col  items-center p-3">
            <div class="row-span-3">
                <img :src="profile.profile_photo_url" alt="no image" class="w-16 md:w-32 lg:w-48 profile_image"/>
            </div>
            <div class="row-span-3">
                <p class="text-sm">
                    {{ profile.email }}
                </p>
            </div>
            <div class="row-span-3">
                <upload-photo/>
            </div>
        </div>

        <div class="bg-gradient-to-r from-green-400 to-blue-500" style="height:15px">  </div>

        <div v-if="images" 
            class="grid gap-3 grid-cols-4 mt-6 justify-start">

            <div v-for="image in images" 
                :key="image.id" class="">

                <div v-if="$page.props.user.id == profile.id" class="absolute cursor-pointer ">

                    <div @click="deleteImage(image.id)" class="hover:text-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </div>

                    <div v-if="image.public == true" @click="togglePublic(image.id)" class="hover:text-blue-600">
                        <svg class="h-6 w -6" xmlns="http://www.w3.org/2000/svg"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </div>

                    <div v-else @click="togglePublic(image.id)" class="hover:text-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                        </svg>
                    </div>

                </div>

                <img :src="`/storage/${image.path}`"  alt="image"   class=" object-center bg-yellow-300 image">

            </div>
        </div>

    </div>
  </app-layout>
</template>

<script>
    import AppLayout from "@/Layouts/AppLayout";
    import UploadPhoto from "@/Components/UploadPhoto";
    import { Inertia } from '@inertiajs/inertia'

    export default {
        props: ["user", "profile", 'images'],

        methods: {
            deleteImage(imageId){
                Inertia.visit(this.route('image.delete'), {
                    onBefore: () => confirm('Are you sure you want to delete this image?'),
                    method: 'delete',
                    data: {
                        image : imageId
                    }
                });
            },

            togglePublic(imageId){
                Inertia.visit(this.route('image.togglePublic'), {
                    method: 'patch',
                    data: {
                        image : imageId
                    }
                })
            }
        },

        components: {
            AppLayout,
            UploadPhoto
        },
   
};
</script>

<style lang="scss" scoped>
    .container{
        padding: 2% 15% 2% 15%;
    }
    .profile_image{
        max-width: 200px;
        min-width: 100px;
        border-radius: 50%;
    }
    .image{
        max-height: 200px;
        min-height: 70px;
        min-width: 70px;
    }
    .first:hover + .second{
        display: visible;
    }
    .second{
        visibility:hidden;
    }
</style>

