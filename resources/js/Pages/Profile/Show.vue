<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ profile.name }}
            </h2>
        </template>

        <p> {{ profile.email }} </p>

        <img :src="profile.profile_photo_url" alt="no image" style="max-width:300px" >

    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import JetSectionBorder from '@/Jetstream/SectionBorder'

    export default {
        props: ['user', 'profile'],

        components: {
            AppLayout,
            JetSectionBorder,
        },
    }
</script>

