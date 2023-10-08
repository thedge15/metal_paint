<script setup>

const emit = defineEmits(['closeStore'])

const closeStore = () => {
    emit('closeStore')
}
</script>
<template>
    <button @click.prevent="closeStore" type="button"
            class="mb-2 mr-2 px-3 py-2.5 w-1/12 text-white text-center bg-gradient-to-r from-teal-400 via-teal-500 to-teal-600
                        hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-teal-300
                        font-medium rounded-lg text-sm">
        Создать
    </button>
</template>

