<script setup>
import {computed} from "vue";
import {useForm} from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";

const props = defineProps({
    hideMaterial: Boolean,
    projects: {
        type: Object,
        default: () => ({})},
    elements: {
        type: Object,
        default: () => ({}),
    },
    metals: {
        type: Object,
        default: () => ({}),
    },
    characteristics: {
        type: Object,
        default: () => ({}),
    },
    standards: {
        type: Object,
        default: () => ({}),
    },
    steels: {
        type: Object,
        default: () => ({}),
    },
    units: {
        type: Object,
        default: () => ({}),
    },
})

const emit = defineEmits(['closeStore'])

const metalCharacteristics = computed(() => {
    return props.characteristics.filter(item => item.metal_id === form.metal_id);
})

const selectedStandards = computed(() => {
    return props.standards.filter(item => item.metal_id === form.metal_id)
})



const form = useForm({
    project_id: '',
    metal_id: '',
    element_id: '',
    characteristic_id: '',
    sheetHeight: '',
    sheetWidth: '',
    metalLength: '',
    standard_id: '',
    steel_id: '',
    quantity: '',
    measure_units: '',
})
const submit = () => {
    form.post(route('store.material'))
    setTimeout(() => {
            if (JSON.stringify(form.errors) === '{}') {
                closeStore();
            } else {
                console.log(form.errors);
            }
        }, (1000)
    )
}

const showResult = () => {
    console.log(form.metal_id);
};

const closeStore = () => {
    form.metal_id = ''
    form.project_id = ''
    form.element_id = ''
    form.characteristic_id = ''
    form.sheetHeight = ''
    form.sheetWidth = ''
    form.metalLength = ''
    form.standard_id = ''
    form.steel_id = ''
    form.quantity = ''
    form.measure_units = ''
    form.clearErrors()
    emit('closeStore')
}
</script>

<template>
    <div :class="['shadow-md sm:rounded-lg', hideMaterial ? '' : 'hidden']">
<!--        <p @click.prevent="showResult">Жмякай</p>-->
        <form @submit.prevent="submit" class="p-2 bg-gray-200">
            <div class="grid grid-cols-6 w-full">
                <div>
                    <label for="project">Раздел РД</label>
                    <select v-model="form.project_id" id="project" class="border border-gray-300
                    focus:ring-blue-500 focus:border-blue-500 h-9">
                        <option v-for="item in projects" :value="item.id">{{ item.title }}</option>
                    </select>
                </div>
                <div class="ml-2">
                    <label for="metal">Конструктивный элемент</label>
                    <select v-model="form.element_id" id="element" class="border border-gray-300
                    focus:ring-blue-500 focus:border-blue-500 h-9">
                        <option v-for="item in elements" :value="item.id">{{ item.title }}</option>
                    </select>
                </div>
                <div class="ml-2">
                    <label for="metal">Металлопрокат</label>
                    <select v-model="form.metal_id" id="metal" class="border border-gray-300
                    focus:ring-blue-500 focus:border-blue-500 h-9">
                        <option v-for="item in props.metals" :value="item.id">{{ item.title }}</option>
                    </select>
                </div>
                <div v-if="form.metal_id" class="ml-2">
                    <label for="characteristic">Размеры</label>
                    <select v-model="form.characteristic_id" id="characteristic" class="border border-gray-300 focus:ring-blue-500
                        focus:border-blue-500 h-9">
                        <option v-for="item in metalCharacteristics" :value="item.id">{{ item.title }}</option>
                    </select>
                    <InputError :message="form.errors.characteristic_id"></InputError>
                </div>
                <div v-if="form.metal_id && form.metal_id === 3" class="ml-2">
                    <label for="sheetHeight">Ширина листа, мм</label>
                    <input v-model="form.sheetHeight" id="sheetHeight" type="number" class="border
                    border-gray-300 focus:ring-blue-500 focus:border-blue-500  h-9">
                </div>
                <div v-if="form.metal_id && form.metal_id === 3" class="ml-2">
                    <label for="sheetWidth">Высота листа, мм</label>
                    <input v-model="form.sheetWidth" id="sheetWidth" type="number" class="border
                    border-gray-300 focus:ring-blue-500 focus:border-blue-500 h-9">
                </div>
                <div
                    v-if="form.metal_id === 4 || form.metal_id === 2 || form.metal === 'Уголок' || form.metal === 'Двутавр'"
                    class="ml-2">
                    <label for="metalLength">Длину, мм (при наличии)</label>
                    <input v-model="form.metalLength" id="metalLength" type="number" class="border
                    border-gray-300 focus:ring-blue-500 focus:border-blue-500 block h-9">
                </div>
            </div>
            <div class="grid grid-cols-6 w-full">
                <div>
                    <label for="standard_id">ГОСТ</label>
                    <select v-model="form.standard_id" id="standard_id" class="mb-2 border border-gray-300 focus:ring-blue-500
                        focus:border-blue-500 h-9">
                        <option v-for="item in selectedStandards" :value="item.id">{{ item.title }}</option>
                    </select>
                    <InputError :message="form.errors.standard_id"></InputError>
                </div>
                <div class="ml-2">
                    <label for="steel_id">Сталь</label>
                    <select v-model="form.steel_id" id="steel" class="border border-gray-300
                    focus:ring-blue-500 focus:border-blue-500 h-9">
                        <option v-for="item in steels" :value="item.id">{{ item.title }} {{ item.steel_standard }}</option>
                    </select>
                    <InputError :message="form.errors.steel_id"></InputError>
                </div>
                <div class="ml-2">
                    <label for="quantity">Количество</label>
                    <input v-model="form.quantity" id="quantity" type="number" step="0.001" class="
                    border border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                    <InputError :message="form.errors.quantity"></InputError>
                </div>
                <div class="ml-2">
                    <label for="unit">Единицы измерения</label>
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
            <button type="submit" :disabled="!form.metal_id"
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

