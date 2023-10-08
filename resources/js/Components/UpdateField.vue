<template>
    <div v-if="hideUpdate || !hideUpdate && item.id !== this.updId">
        {{ item[this.fieldName] }}
    </div>
    <div v-if="fieldName === 'numb'"></div>
    <div v-if="!hideUpdate && item.id === this.updId">
        <input v-model="updNumb" id="updPosition" class="h-8 bg-gray-50 border border-gray-600
                            text-gray-900 text-sm italic text-center rounded-lg focus:ring-blue-500 focus:border-blue-500
                            block w-full text-xs">
    </div>
</template>

<script>
export default {
    name: "UpdateField",

    data() {
        return {
            updNumb: this.item.numb,
        }
    },

    props: [
        'hideUpdate',
        'updId',
        'item',
        'fieldName',
        'updParameter'
    ],
}
</script>

<style scoped>

</style>
