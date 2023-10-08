<script setup>
import {ref} from 'vue';


const showingNavigationDropdown = ref(false);

</script>

<template>
    <div class="max-h-screen ml-60 bg-gray-100">
        <guest-sidebar></guest-sidebar>
        <!-- Page Content -->
        <main>
            <main class="max-h-screen overflow-auto bg-gray-100">
                <div class="px-6">
                    <slot/>
                </div>
            </main>
        </main>
    </div>
</template>


<script>
import GuestSidebar from "@/Components/GuestSidebar.vue";

export default {

    data() {
        return {}
    },

    components: {
        GuestSidebar
    },

}

</script>
