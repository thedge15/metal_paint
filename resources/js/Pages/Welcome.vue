<script setup>
import {Link} from "@inertiajs/vue3";
</script>
<template>
    <div class="text-gray-100 font-[Poppins]">
        <nav class="fixed top-0 left-0 w-full py-6">
            <div class="container mx-auto flex justify-center">
                <ul class="text-sm tracking-wide items-center flex gap-x-8">
                    <li class="hover:scale-125 duration-300 py-1 hover:text-teal-400">
                        <Link href="#" class="cursor-pointer">Home</Link>
                    </li>
                    <li class="hover:scale-125 duration-300 py-1 hover:text-teal-400">
                        <Link href="#" class="cursor-pointer">Product</Link>
                    </li>
                    <li class="hover:scale-125 duration-300 py-1 hover:text-teal-400">
                        <Link href="#" class="cursor-pointer">About us</Link>
                    </li>
                    <li class="hover:scale-125 duration-300 py-1 hover:text-teal-400">
                        <Link :href="route('index.elements')" class="cursor-pointer">Elements</Link>
                    </li>
                    <Link :href="route('index.bush')">
                        <button class="bg-teal-600 px-7 rounded-full tracking-wide py-3 text-xs hover:scale-110 duration-300">
                            TO BUSHES
                        </button>
                    </Link>
                </ul>
            </div>
        </nav>
        <section class="bg-[#23304c] mx-auto h-screen flex px-[10%] py-[6%]">
            <div class="flex-1 pt-7">
                <div class="absolute">
                    <h1 class="text-3xl leading-normal py-6">
                        Приложение для расчёта<br/>
                        окраски металлоконструкций<br/>
                        газовых кустов
                    </h1>
                    <Link :href="route('index.bush')">
                        <button
                            class="bg-teal-600 px-7 rounded-full tracking-wide py-3 text-xs hover:scale-110 duration-300">
                            К КУСТАМ
                        </button>
                    </Link>
                </div>
            </div>
        </section>
    </div>
</template>
