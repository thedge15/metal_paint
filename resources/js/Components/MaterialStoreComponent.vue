<script setup>
import {computed} from "vue";
import {useForm} from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";

const props = defineProps({
    hideMaterial: Boolean,
    project_id: Number,
    elements: {
        type: Array,
        default: () => ({}),
    },
    metals: {
        type: Array,
        default: () => ({}),
    },
    characteristics: {
        type: Array,
        default: () => ({}),
    },
    standards: {
        type: Array,
        default: () => ({}),
    },
    steels: {
        type: Array,
        default: () => ({}),
    },
    units: {
        type: Array,
        default: () => ({}),
    },
})

const emit = defineEmits(['closeStore'])

const metalCharacteristics = computed(() => {
    return props.characteristics.filter(item => item.metal.data.title === form.metal);
})

const selectedStandards = computed(() => {
    return props.standards.filter(item => item.metal === form.metal)
})

const form = useForm({
    project_id: props.project_id,
    metal: '',
    element: '',
    title: '',
    sheetHeight: '',
    sheetWidth: '',
    metalLength: '',
    standard: '',
    steel: '',
    quantity: '',
    measure_units: '',
})
const submit = () => {
    form.post(route('store.material'))
    setTimeout(() => {
            if (JSON.stringify(form.errors) === '{}') {
                closeStore();
            } else {
                console.log('Validation error');
            }
        }, (1000)
    )
}
const closeStore = () => {
    form.metal = ''
    form.element = ''
    form.title = ''
    form.sheetHeight = ''
    form.sheetWidth = ''
    form.metalLength = ''
    form.standard = ''
    form.steel = ''
    form.quantity = ''
    form.measure_units = ''
    form.clearErrors()
    emit('closeStore')
}
</script>

<template>
    <div :class="['shadow-md sm:rounded-lg', hideMaterial ? '' : 'hidden']">
        <form @submit.prevent="submit" class="p-2 bg-gray-200">
            <div class="grid grid-cols-5 w-full">
                <div>
                    <label for="metal">Выберите конструктивный элемент</label>
                    <select v-model="form.element" id="element" class="border border-gray-300
                    focus:ring-blue-500 focus:border-blue-500 h-9">
                        <option v-for="item in elements">{{ item.title }}</option>
                    </select>
                </div>
                <div class="ml-2">
                    <label for="metal">Выберите металлопрокат</label>
                    <select v-model="form.metal" id="metal" class="border border-gray-300
                    focus:ring-blue-500 focus:border-blue-500 h-9">
                        <option v-for="item in metals">{{ item.title }}</option>
                    </select>
                </div>
                <div v-if="form.metal" class="ml-2">
                    <label for="characteristic">Выберите размеры</label>
                    <select v-model="form.title" id="characteristic" class="border border-gray-300 focus:ring-blue-500
                        focus:border-blue-500 h-9">
                        <option v-for="item in metalCharacteristics">{{ item.title }}</option>
                    </select>
                    <InputError :message="form.errors.title"></InputError>
                </div>
                <div v-if="form.metal && form.metal === 'Лист'" class="ml-2">
                    <label for="sheetHeight">Введите ширину листа, мм</label>
                    <input v-model="form.sheetHeight" id="sheetHeight" type="number" class="border
                    border-gray-300 focus:ring-blue-500 focus:border-blue-500  h-9">
                </div>
                <div v-if="form.metal && form.metal === 'Лист'" class="ml-2">
                    <label for="sheetWidth">Введите высоту листа, мм</label>
                    <input v-model="form.sheetWidth" id="sheetWidth" type="number" class="border
                    border-gray-300 focus:ring-blue-500 focus:border-blue-500 h-9">
                </div>
                <div
                    v-if="form.metal === 'Труба' || form.metal === 'Швеллер' || form.metal === 'Уголок' || form.metal === 'Двутавр'"
                    class="ml-2">
                    <label for="metalLength">Введите длину, мм (при наличии)</label>
                    <input v-model="form.metalLength" id="metalLength" type="number" class="border
                    border-gray-300 focus:ring-blue-500 focus:border-blue-500 block h-9">
                </div>
            </div>
            <div class="grid grid-cols-5 w-full">
                <div>
                    <label for="standard">Выберите ГОСТ</label>
                    <select v-model="form.standard" id="standard" class="mb-2 border border-gray-300 focus:ring-blue-500
                        focus:border-blue-500 h-9">
                        <option v-for="item in selectedStandards">{{ item.title }}</option>
                    </select>
                    <InputError :message="form.errors.standard"></InputError>
                </div>
                <div class="ml-2">
                    <label for="steel">Выберите сталь</label>
                    <select v-model="form.steel" id="steel" class="border border-gray-300
                    focus:ring-blue-500 focus:border-blue-500 h-9">
                        <option v-for="item in steels">{{ item.title }} {{ item.steel_standard }}</option>
                    </select>
                    <InputError :message="form.errors.steel"></InputError>
                </div>
                <div class="ml-2">
                    <label for="quantity">Введите количество</label>
                    <input v-model="form.quantity" id="quantity" type="number" step="0.001" class="
                    border border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                    <InputError :message="form.errors.quantity"></InputError>
                </div>
                <div class="ml-2">
                    <label for="unit">Выберите единицы измерения</label>
                    <div v-if="!form.metalLength && !form.sheetHeight">
                        <select v-model="form.measure_units" id="unit"
                                class="border border-gray-300 focus:ring-blue-500 focus:border-blue-500 block">
                            <option class="italic" v-for="item in units">{{ item }}</option>
                        </select>
                    </div>
                    <div v-if="form.metalLength || form.sheetHeight">
                        <select v-model="form.measure_units" id="unit"
                                class="border border-gray-300 focus:ring-blue-500 focus:border-blue-500 block">
                            <option> {{ 'шт.' }}</option>
                        </select>
                    </div>
                    <InputError :message="form.errors.measure_units"></InputError>
                </div>
            </div>
            <button type="submit" :disabled="!form.metal"
                    class="text-gray-900 bg-gradient-to-r from-lime-200 via-lime-400 to-lime-500 hover:bg-gradient-to-br
                focus:ring-4 focus:outline-none focus:ring-lime-300 font-medium text-sm px-5 py-2.5 text-center mr-2">
                Создать
            </button>
            <button @click.prevent="closeStore" type="button"
                    class="text-white bg-gradient-to-r from-pink-400 via-pink-500 to-pink-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-pink-300 font-medium text-sm px-5 py-2.5 text-center mr-2 my-2">
                Отмена
            </button>
        </form>
    </div>
</template>

