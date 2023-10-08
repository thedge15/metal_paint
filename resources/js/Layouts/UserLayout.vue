<template>
    <div :class="['max-h-screen', this.hideSidebar ? '' : 'ml-60']">
        <div class="bg-gray-100">
            <guest-sidebar :class="[this.hideSidebar ? 'hidden' : '']"></guest-sidebar>
            <!-- Page Content -->
            <main>
                <main class="max-h-screen overflow-auto bg-gray-100">

                    <div class="px-6">
                        <div class="flex flex-col h-screen pb-5">
                            <div>
                                <svg @click.prevent="this.hideSidebar = !this.hideSidebar"
                                     xmlns="http://www.w3.org/2000/svg"
                                     fill="blue" viewBox="0 0 24 24" stroke-width="1.5" stroke="blue" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          :d="[!this.hideSidebar ? 'M21 16.811c0 .864-.933 \n'+
'                                   1.405-1.683.977l-7.108-4.062a1.125 1.125 0 010-1.953l7.108-4.062A1.125 1.125 0 0121 \n'+
'                                   8.688v8.123zM11.25 16.811c0 .864-.933 1.405-1.683.977l-7.108-4.062a1.125 1.125 0 \n'+
'                                   010-1.953L9.567 7.71a1.125 1.125 0 011.683.977v8.123z' : 'M3 8.688c0-.864.933-1.405 ' +
                                    '1.683-.977l7.108 4.062a1.125 1.125 0 010 1.953l-7.108 4.062A1.125 1.125 0 013 ' +
                                    '16.81V8.688zM12.75 8.688c0-.864.933-1.405 1.683-.977l7.108 4.062a1.125 1.125 0 010 ' +
                                    '1.953l-7.108 4.062a1.125 1.125 0 01-1.683-.977V8.688z']"/>
                                </svg>
                            </div>
                            <slot/>
                        </div>
                    </div>
                </main>
            </main>
        </div>
    </div>
</template>


<script>
import GuestSidebar from "@/Components/GuestSidebar.vue";

export default {

    components: {
        GuestSidebar
    },

    data() {
        return {
            hideSidebar: false,
        }
    }
}

</script>

<style>
label {
    margin-bottom: 2px;
    color: #2d3748;
    font-size: .875rem;
    line-height: 1.25rem;
    font-weight: 500;
    display: block;
}

select {
    border-radius: .5rem;
    width: 100%;
    display: block;
    background-color: rgb(249 250 251);
    margin-bottom: .5rem;
    height: 2rem;
    color: rgb(17 24 39);
    font-size: 0.875rem; /* 14px */
    line-height: 1.25rem; /* 20px */
}

input {
    border-radius: .5rem;
    width: 100%;
    display: block;
    background-color: rgb(249 250 251);
    margin-bottom: .5rem;
    height: 2rem;
    color: rgb(17 24 39);
    font-size: 0.875rem; /* 14px */
    line-height: 1.25rem; /* 20px */
}

button {
    border-radius: .5rem
}

th {
    position: sticky;
    top: 0;
    padding: .5rem;
    color: rgb(224 231 255);
    background-color: rgb(99 102 241);
}


</style>
