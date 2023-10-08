<template>
    <div v-if="delElement" :class="['bg bg-gray-200 shadow-md sm:rounded-lg w-full', hideDelete ? '' : 'hidden']">
        <p class="p-2 italic">Вы вот прям точно хотите удалить "{{ delElement.title }}"?</p>
        <button @click.prevent="deleteMaterial" type="button"
                class="mx-2 mb-2 px-5 py-2.5 text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600
                hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg
                text-sm text-center">
            Удалить
        </button>
        <button @click.prevent="closeDelete" type="button"
                class="mr-2 mb-2 px-5 py-2.5 text-white bg-gradient-to-r from-pink-400 via-pink-500 to-pink-600
                hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-pink-300
                font-medium rounded-lg text-sm text-center">
            Отмена
        </button>
    </div>
</template>

<script>

export default {
    name: "DeleteComponent",

    props: [
        'delElement',
        'hideDelete',
        'delTitle',
    ],


    methods: {
        deleteMaterial() {
            this.$inertia.delete(route(`destroy.${this.delTitle}`, this.delElement.id))
            this.$emit('closeDelete')
        },

        closeDelete() {
            this.$emit('closeDelete')
        },
    },
}
</script>
