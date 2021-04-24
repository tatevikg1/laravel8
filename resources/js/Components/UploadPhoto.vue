<template>
    <div class="bg-grey-lighter" >
        <form @submit.prevent="submit">
            <label class="w-40 flex flex-col items-center px-4 py-3 bg-white text-blue rounded-lg shadow-lg tracking-wide uppercase border border-blue cursor-pointer hover:bg-blue">
                <svg class="w-8 h-8" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                </svg>
                <span class="mt-2 text-base leading-normal">Select a file</span>
                <input type='file' class="hidden"  @input="submit($event)" />
            </label>

            <div>
                <progress v-if="form.progress" :value="form.progress.percentage" max="100" class="progress">
                    {{ form.progress.percentage }}%
                </progress>
            </div>
            <button type="submit" ></button>
        </form>
    </div>
</template>

<script>
import { useForm } from '@inertiajs/inertia-vue3'

export default {
    setup () {
        const form = useForm({
            photo: null,
        })

        function submit($event) {
            form.photo = $event.target.files[0];
            form.post(route('image.store'));
        }

        return { form, submit }
    },
}
</script>
    
<style lang="scss" scoped>
.progress{
    width: 150px;
}
</style>