<script setup>

import {useForm} from "@inertiajs/vue3";

const props = defineProps({
    hideMaterial: Boolean,
    element: String,
    elementTitle: String,
    bush_id: Number,
    metals: {
        type: Object,
        default: () => ({}),
    },
    projects: {
        type: Object,
        default: () => ({}),
    },
})

const emit = defineEmits(['closeStore'])
const standardTypes = ['ГОСТ', 'ТУ', 'СТО']

const form = useForm({
    bush_id: props.bush_id,
    title: '',
    consumption: '',
    steel_standard: '',
    change: '',
    metal: '',
    standardType: '',
    standardNumber: '',
    project: '',
    quantity: '',
})
const submit = () => {
    if (props.element === 'standard') {
        form.title = form.standardType + ' ' + form.standardNumber
    }
    form.post(route(`store.${props.element}`))
    setTimeout(() => {
            if (JSON.stringify(form.errors) === '{}') {
                closeStore();
            } else {
                console.log(form.errors);
            }
        }, (1000)
    )
}
const closeStore = () => {
    form.title = ''
    form.consumption = ''
    form.steel_standard = ''
    form.change = ''
    form.metal = ''
    form.standardType = ''
    form.standardNumber = ''
    form.project = ''
    form.quantity = ''

    emit('closeStore')
}
</script>

<template>
    <div :class="['shadow-md sm:rounded-lg group-hover:animate-trans-right', hideMaterial ? '' : 'hidden']">
        <form @submit.prevent="submit" class="p-4 bg-gray-200 mt-4 w-full">
            <div class="grid grid-cols-4 w-full mb-3">
                <div v-if="element !== 'standard'">
                    <label for="title" class="text-amber=200">Наименование {{ elementTitle }}</label>
                    <input v-model="form.title" type="text" id="title"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500
                               focus:border-blue-500 block w-full p-2.5"
                           :placeholder="[`Наименование ${ elementTitle }`]" required>
                    <p v-if="form.errors.title" class="text-red-600 mb-2 italic">{{ form.errors.title }}</p>
                </div>
                <div v-if="element === 'paint'" class="ml-2">
                    <label for="consumption" class="text-amber=200">Расход краски</label>
                    <input v-model="form.consumption" type="text" id="consumption"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                           placeholder="Расход краски" required>
                    <p v-if="form.errors.consumption" class="text-red-600 mb-2 italic">{{ form.errors.consumption }}</p>
                </div>
                <div v-if="element === 'steel'" class="ml-2">
                    <label for="steelStandard" class="text-amber=200">ГОСТ марки стали</label>
                    <input v-model="form.steel_standard" type="text" id="steelStandard"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                           placeholder="ГОСТ марки стали" required>
                    <p v-if="form.errors.steel_standard" class="text-red-600 mb-2 italic">{{ form.errors.steel_standard }}</p>
                </div>
                <div v-if="element === 'project'" class="ml-2">
                    <label for="change" class="text-amber=200">Изм. №</label>
                    <input v-model="form.change" type="number" id="change"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                           placeholder="Изм. №" required>
                    <p v-if="form.errors.change" class="text-red-600 mb-2 italic">{{ form.errors.change }}</p>
                </div>
                <div v-if="element === 'standard'" class="ml-2">
                    <label for="metal" class="text-amber=200 mb-2">Металл</label>
                    <select v-model="form.metal" id="metal"
                            class="bg-gray-50 mb-3 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full">
                        <option v-for="item in metals">{{ item.title }}</option>
                    </select>
                    <p v-if="form.errors.metal" class="text-red-600 mb-2 italic">{{ form.errors.metal }}</p>
                </div>
                <div v-if="element === 'standard'" class="ml-2">
                    <label for="standardType" class="text-amber=200 mb-2">Тип стандарта</label>
                    <select v-model="form.standardType" id="standardType"
                            class="bg-gray-50 mb-3 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full">
                        <option v-for="item in standardTypes">{{ item }}</option>
                    </select>
                    <p v-if="form.errors.standardType" class="text-red-600 mb-2 italic">{{ form.errors.standardType }}</p>
                </div>
                <div v-if="element === 'standard'" class="ml-2">
                    <label for="title" class="text-amber=200 mb-2">Номер стандарта</label>
                    <input v-model="form.standardNumber" type="text" id="title"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                           placeholder="Номер стандарта" required>
                    <p v-if="form.errors.standardNumber" class="text-red-600 mb-2 italic">{{ form.errors.standardNumber }}</p>
                </div>
            </div>
            <button type="submit"
                    class="text-gray-900 bg-gradient-to-r from-lime-200 via-lime-400 to-lime-500
                                            hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-lime-300
                                            font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2">
                Создать
            </button>
            <button @click.prevent="closeStore" type="button"
                    class="text-white bg-gradient-to-r from-pink-400 via-pink-500 to-pink-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-pink-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
                Отмена
            </button>
        </form>
    </div>
</template>

