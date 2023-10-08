<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import {Link} from '@inertiajs/vue3';

defineProps(['title'])
</script>

<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 h-full bg-gray-50">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <a :href="route('welcome')">
                <img class="mx-auto h-10 w-auto cursor-pointer"
                     src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="Your Company"/>
            </a>
            <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">{{ title }}</h2>
        </div>
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <div class="flex min-h-full flex-1 flex-col justify-center px-6 py-4 lg:px-8">
                <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
                    <slot/>
                </div>
            </div>
        </div>
    </div>
</template>

<!--
       This example requires updating your template:

       ```
       <html class="">
       <body class="h-full">
       ```
     -->
