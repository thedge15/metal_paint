<script setup>
import {useForm} from "@inertiajs/vue3";

const props = defineProps({
    hideProduct: Boolean,
    metal: Object,
})

const form = useForm({
    metal_id: props.metal.id,
    title: '',
    width: '',
    height: '',
    wall: '',
    size: '',
    second_size: '',
    thickness: '',
    diameter: '',
    ton_length: '',
    ton_area: '',
})

const emit = defineEmits(['closeStore'])

const submit = () => {
    if (props.metal.title === 'Труба' || props.metal.title === 'Круг') {
        form.ton_area = (parseFloat(form.diameter) * Math.PI * parseFloat(form.ton_length))/1000
    } else if (props.metal.title === 'Труба квадратная') {
        form.ton_area = 2 * (form.height / 1000 + form.width / 1000) * form.ton_length
    }

    form.post(route('store.characteristic'))
    if (JSON.stringify(form.errors) === '{}') {
        closeStore();
    } else {
        console.log(form.errors);
    }
}
const closeStore = () => {
    form.reset()
    emit('closeStore')
}
</script>
<template>
    <div :class="['shadow-md sm:rounded-lg ', hideProduct ? '' : 'hidden']">
        <form @submit.prevent="submit" class="p-4 bg-gray-200 mt-4 w-full">
            <div class="grid gap-6 mb-6 md:grid-cols-5">
                <div
                    v-if="metal.title === 'Швеллер'
                            || metal.title === 'Двутавр' || metal.title === 'Лист просечно-вытяжной'
                            || metal.title === 'Профлист'">
                    <label for="title" class="text-orange-600">Марка металлопроката</label>
                    <input v-model="form.title" type="text" id="title"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500
                        focus:border-blue-500 block w-full p-2.5" placeholder="Марка металлопроката" required>
                </div>
                <div v-if="metal.title === 'Уголок'">
                    <label for="size" class="text-orange-600">Длина полки уголка</label>
                    <input v-model="form.size" type="number" id="size"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500
                        focus:border-blue-500 block w-full p-2.5" placeholder="Длина полки уголка" required>
                </div>
                <div v-if="metal.title === 'Уголок'">
                    <label for="second_size" class="text-orange-600">Длина второй полки уголка</label>
                    <input v-model="form.second_size" type="number" id="second_size"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500
                        focus:border-blue-500 block w-full p-2.5" placeholder="Длина второй полки уголка" required>
                </div>
                <div v-if="metal.title === 'Труба' || metal.title === 'Круг'">
                    <label for="diameter" class="text-orange-600">Диаметр</label>
                    <input v-model="form.diameter" type="number" id="diameter"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500
                        focus:border-blue-500 block w-full p-2.5" placeholder="Диаметр" required>
                </div>
                <div v-if="metal.title === 'Труба квадратная'">
                    <label for="width" class="text-orange-600">Ширина квадратной трубы</label>
                    <input v-model="form.width" type="number" id="width"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500
                        focus:border-blue-500 block w-full p-2.5" placeholder="Ширина квадратной трубы" required>
                </div>
                <div v-if="metal.title === 'Труба квадратная'">
                    <label for="height" class="text-orange-600">Высота квадратной трубы</label>
                    <input v-model="form.height" type="number" id="height"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500
                        focus:border-blue-500 block w-full p-2.5" placeholder="Высота квадратной трубы" required>
                </div>
                <div
                    v-if="metal.title === 'Уголок' || metal.title === 'Труба' || metal.title === 'Труба квадратная'">
                    <label for="wall" class="text-orange-600">Толщина стенки</label>
                    <input v-model="form.wall" type="number" id="wall"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500
                        focus:border-blue-500 block w-full p-2.5" placeholder="Толщина стенки" required>
                </div>
                <div v-if="metal.title === 'Лист' || metal.title === 'Лист рулонный'">
                    <label for="thickness" class="text-orange-600">Толщина листа</label>
                    <input v-model="form.thickness" type="number" id="thickness"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500
                        focus:border-blue-500 block w-full p-2.5" placeholder="Толщина листа" required>
                </div>
                <div v-if="metal.title !== 'Лист'
                        && metal.title !== 'Лист просечно-вытяжной'
                        && metal.title !== 'Профлист'
                        && metal.title !== 'Лист рулонный'">
                    <label for="tonLength" class="text-orange-600">Длина тонны металлопроката</label>
                    <input v-model="form.ton_length" type="number" step="0.01" id="tonLength"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500
                        focus:border-blue-500 block w-full p-2.5" placeholder="Длина тонны металлопроката"
                           pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}" required>
                </div>
                <div
                    v-if="metal.title !== 'Труба' && metal.title !== 'Труба квадратная' && metal.title !== 'Круг'">
                    <label for="tonArea" class="text-orange-600">Площадь тонны металлопроката</label>
                    <input v-model="form.ton_area" type="number" step="0.01" id="tonArea"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500
                        focus:border-blue-500 block w-full p-2.5" placeholder="Площадь тонны металлопроката"
                           pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}" required>
                </div>
            </div>
            <button type="submit" class="text-gray-900 bg-gradient-to-r from-lime-200 via-lime-400 to-lime-500
                hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-lime-300 font-medium rounded-lg
                text-sm px-5 py-2.5 text-center mr-2 mb-2">
                Создать
            </button>
            <button @click.prevent="closeStore" type="button"
                    class="text-white bg-gradient-to-r from-pink-400 via-pink-500 to-pink-600 hover:bg-gradient-to-br
                focus:ring-4 focus:outline-none focus:ring-pink-300 font-medium rounded-lg text-sm px-5 py-2.5
                text-center mr-2 mb-2">
                Отмена
            </button>
        </form>
    </div>
</template>
