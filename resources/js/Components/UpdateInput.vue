<template>
    <div v-if="hideUpdate || !hideUpdate && item.id !== updId">
        {{ item.title }}
    </div>
    <div v-if="!hideUpdate && item.id === updId">
        <input v-model="updPosition" id="updPosition" class="h-8 bg-gray-50 border border-gray-600 text-gray-900 text-sm
            italic text-center rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full block text-xs">
    </div>
</template>

<script>
export default {
    name: "UpdateInput",

    data() {
        return {
            updPosition: this.item.title,
        }
    },

    props: [
        'hideUpdate',
        'item',
        'updId',
        'updTitle',
    ],
}
</script>

<style scoped>

</style>
