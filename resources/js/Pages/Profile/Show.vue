<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ profile.name }}
      </h2>
    </template>
    <div class="p-8">

        <div class="grid grid-rows-3 grid-flow-col  items-center p-3">
            <div class="row-span-3">
                <img :src="profile.profile_photo_url" alt="no image" class="w-16 md:w-32 lg:w-48 profile_image"/>
            </div>
            <div class="row-span-3">
                <p>{{ profile.email }}</p>
            </div>
            <div class="row-span-3">
                <upload-photo/>
            </div>
        </div>

        <div class="bg-gradient-to-r from-green-400 to-blue-500" style="height:15px">  </div>

        <div v-if="images" class="grid gap-3 grid-cols-4 mt-6">
            <div v-for="image in images" :key="image.id" class="">
                <img :src="`/storage/${image.path}`" alt="image" class="image items-center">
            </div>
        </div>

    </div>
  </app-layout>
</template>

<script>
    import AppLayout from "@/Layouts/AppLayout";
    import UploadPhoto from "@/Components/UploadPhoto";

    export default {
        props: ["user", "profile", 'images'],


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
</style>

