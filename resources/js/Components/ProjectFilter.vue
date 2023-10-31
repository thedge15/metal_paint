<script setup>

import {computed, ref, watch, onMounted} from "vue";

const selectedProject = ref('РД');
const hideProjectFilter = ref(false);

const props = defineProps({
    columnName: {
        type: String,
        default: 'РД',
    },

    filterCollection: {
        type: Object,
        default: () => ([]),
    },
})

onMounted( () => {
    console.log(selectedProject.value);
})

const showFilter = () => {
    hideProjectFilter.value = !hideProjectFilter.value
}

const emit = defineEmits(['filterProject'])

watch(selectedProject, () => {
    emit('filterProject', selectedProject.value)
})
const closeProjectFilter = () => {
    selectedProject.value = props.columnName
    showFilter()
}
</script>
<template>
    <div>
        <div v-if="!hideProjectFilter" class="flex justify-center">
            <div class="py-2">
                РД
            </div>
            <svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 24 24" stroke-width="1.5"
                class="w-6 ml-3 h-8 cursor-pointer fill-none stroke-current hover:stroke-yellow-500" @click.prevent="showFilter">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917
                    1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244
                    2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32
                    48.32 0 0112 3z"/>
            </svg>
        </div>
        <div v-if="hideProjectFilter" class="flex justify-center">
            <div class="py-2">
                <select v-model="selectedProject" class="bg-gray-50 border border-gray-600 text-gray-900 text-sm italic
                    text-center rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-32 h-8 text-xs">
                    <option class="w-32">РД</option>
                    <option class="w-32" v-for="material in props.filterCollection">{{ material }}</option>
                </select>
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                 @click.prevent="closeProjectFilter" stroke-width="1.5" stroke="currentColor" class="w-6 ml-3 h-8
                cursor-pointer pt-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </div>
    </div>
</template>
