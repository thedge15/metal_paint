<template>
    <div v-if="updProduct[field] === item[field]  && this.field === fieldName" class="flex justify-center">
        <svg @click.prevent="updateProduct(element)" xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 24 24" stroke-width="1.5" stroke="green" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
        </svg>
        <input v-model="updPosition" id="updPosition" class="bg-gray-50 border border-gray-600
            text-gray-900 text-sm italic text-center rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-64 text-xs">
        <svg @click.prevent="closeUpdate" xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 24 24" stroke-width="1.5" stroke="red" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </div>
    <div v-if="updProduct[field] !== item[field] || this.field !== fieldName" class="flex justify-center">
        <div>{{ item[field] }}</div>
        <div>
            <svg @click.prevent="showUpdate(item, fieldName)"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="blue" class="w-6 h-4 mx-auto cursor-pointer">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6
                    18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75
                    21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/>
            </svg>
        </div>
    </div>
</template>

<script>
export default {
    name: "UpdateComponent",

    data() {
        return {
            updProduct: '',
            updPosition: '',
        }
    },

    props: [
        'item',
        'field',
        'element',
        'fieldName',
    ],

    methods: {
        showUpdate(item)
        {
            this.updProduct = item
            this.updPosition = item[this.field]
        },

        updateProduct(element) {
            const updateData = {}

            updateData[this.field] = this.updPosition
            console.log(updateData);
            this.$inertia.patch(route(`update.${element}`, this.updProduct.id), updateData);
            this.updProduct = ''
        },

        closeUpdate() {
            this.updPosition = ''
            this.updProduct = ''
        }
    },

}
</script>

<style scoped>

</style>
