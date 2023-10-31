<script setup>

import UserLayout from "@/Layouts/UserLayout.vue";
import {Link, useForm} from "@inertiajs/vue3";
import {computed, ref} from "vue";
import MaterialStoreComponent from "@/Components/MaterialStoreComponent.vue";
import CreateButton from "@/Components/CreateButton.vue";
import UpdateButton from "@/Components/UpdateButton.vue";
import DeleteButton from "@/Components/DeleteButton.vue";
import PaintFilter from "@/Components/PaintFilter.vue";
import ExportButton from "@/Components/ExportButton.vue";



const checkedMaterials = ref([]);
const hideMaterial = ref(false);
const hideUpdate = ref(true);
const selectedPaint = ref("Краска");
const selectedColor = ref("Цвет");
const updProduct = ref();
const updId = ref();
const updNumb = ref();
const updElement = ref();
const updMetal = ref();
const updCharacteristic = ref();
const updTitle = ref();
const updStandard = ref();
const updSteel = ref();
const updWeight = ref();
const updArea = ref();
const updPaint = ref();
const updPaintColor = ref();
const updNumberOfLayers = ref('Слои');
const updIsPile = ref();
const layers = ref([1, 2, 3]);

const props = defineProps({
    project: Object,
    metals: {
        type: Array,
        default: () => ({}),
    },
    materials: {
        type: Array,
        default: () => ({}),
    },
    characteristics: {
        type: Array,
        default: () => ({})
    },
    standards: {
        type: Array,
        default: () => ({})
    },
    steels: {
        type: Array,
        default: () => ({})
    },
    units: {
        type: Array,
        default: () => ({})
    },
    elements: {
        type: Array,
        default: () => ({})
    },
    paints: {
        type: Array,
        default: () => ({})
    },
    colors: {
        type: Object,
        default: () => ({})
    },
})

const closeStore = () => {
    hideMaterial.value = !hideMaterial.value
}
const filterPaint = (data) => {
    selectedPaint.value = data
}
const filterColor = (data) => {
    selectedColor.value = data
}
const showUpdate = (item) => {
    hideUpdate.value = !hideUpdate.value
    updProduct.value = item
    updId.value = item.id
    form.element = item.element
    form.weight = item.weight
    form.metal = item.metal
    form.characteristic = item.characteristic
    form.title = item.title
    form.standard = item.standard
    form.steel = item.steel
    form.area = item.area
    form.paint = item.paint
    form.paint_color = item.paint_color
    form.number_of_layers = item.number_of_layers
    form.is_pile = Boolean(item.is_pile)
}

const form = useForm({
    id: updId.value,
    numb: '',
    element_id: '',
    metal_id: '',
    characteristic_id: '',
    standard: '',
    steel: '',
    weight: '',
    area: updArea.value,
    paint: updPaint.value,
    paint_color: updPaintColor.value,
    number_of_layers: updNumberOfLayers.value,
    is_pile: updIsPile.value,
})
const submit = () => {
    form.put(route('update.material', updId.value))
    setTimeout(() => {
            if (JSON.stringify(form.errors) === '{}') {
                closeUpdate();
            } else {
                console.log('Validation error');
            }
        }, (1000)
    )
}
const closeUpdate = () => {
    hideUpdate.value = !hideUpdate.value
    updId.value = ''
    updId.value = ''
    form.clearErrors()
}

const selectedStandards = computed(() => {
    if (form.metal_id) {
        return props.standards.filter(item => item.metal_id === form.metal_id)
    }
})

const selectedCharacteristics = computed(() => {
    if (form.metal_id) {
        return props.characteristics.filter(item => item.metal_id === form.metal_id)
    }
})

const allSelectedMaterials = computed(() => {
    return props.materials.filter(material => checkedMaterials.value.includes(material.id));
})

const selectedMaterialWeight = computed(() => {
    const materialWeight = allSelectedMaterials.value.map((material) => material.weight)
    return materialWeight.reduce(function (a, b) {
        return Number(a) + Number(b);
    }, 0);
})

const selectedMaterialPaint = computed(() => {
    const materialPaint = allSelectedMaterials.value.map((material) => material.paint_quantity)
    return materialPaint.reduce(function (a, b) {
        return Number(a) + Number(b);
    }, 0);
})

const selectedPaintArray = computed(() => {
    if (selectedPaint.value === "Краска" && selectedColor.value === "Цвет") {
        return props.materials;
    }
    if (selectedPaint.value !== "Краска" && selectedColor.value === "Цвет") {
        return props.materials.filter(item => item.paint === selectedPaint.value);
    }
    if (selectedPaint.value === "Краска" && selectedColor.value !== "Цвет") {
        return props.materials.filter(item => item.paint_color === selectedColor.value);
    }
    if (selectedPaint.value !== "Краска" && selectedColor.value !== "Цвет") {
        return props.materials.filter(item => item.paint === selectedPaint.value).filter(item => item.paint_color === selectedColor.value);
    }
})

const selectAll = computed({
    get() {
        return selectedPaintArray ? checkedMaterials.value.length === selectedPaintArray.value.length : false;
    },
    set(value) {
        const selected = [];
        if (value) {
            selectedPaintArray.value.forEach(function (material) {
                selected.push(material.id);
            });
        }
        checkedMaterials.value = selected;
    }
})
</script>

<template>
    <UserLayout>
        <div v-if="project" class="text-center italic">
            <Link :href="route('show.bush', project.bush_id)">
                {{ project.title }}
            </Link>
        </div>
        ssss{{ form.metal }}
        <div class="flex justify-between">
            <CreateButton @closeStore="closeStore" :disabled="hideMaterial"></CreateButton>
            <ExportButton :export-route="'export.project'" :export-element="project"></ExportButton>
        </div>
<!--        Эдемент{{ form.element_id}} Метал{{form.metal_id }} Хар-ка {{ form.characteristic_id }} ГОСТ{{ form.standard_id }} Сталь {{ form.steel_id }}-->
        <!-- component -->
        <div class="flex-grow overflow-auto">
            <table class="relative w-full border mb-3 text-xs table-fixed">
                <thead>
                <tr>
                    <th class="w-6"><input type="checkbox" v-model="selectAll"></th>
                    <th class="w-16">№ РФ</th>
                    <th class="w-64">Конструктивный элемент</th>
                    <th>Наименование и техническая характеристика</th>
                    <th class="w-28">Количество, т</th>
                    <th class="w-128">
                        <PaintFilter :paints="paints" :colors="colors" @filterPaint="filterPaint"
                                     @filterColor="filterColor"/>
                    </th>
                    <th class="w-24">Ред.</th>
                    <th class="w-24">Удаление</th>
                </tr>
                </thead>
                <tbody class="divide-y bg-gray-100 font-[Poppins]">
                <tr v-for="(item, index) in selectedPaintArray">
                    <td :class='["px-2 py-1.5 text-center", index%2 === 0 ? "" : "bg-gray-300"]'>
                        <input type="checkbox" :value="item.id" v-model="checkedMaterials">
                        <span class="hidden">{{ item.id }}</span>
                    </td>
                    <td :class='["px-2 py-1.5 text-center", index%2 === 0 ? "" : "bg-gray-300"]'>
                        <div v-if="hideUpdate || !hideUpdate && item.id !== updId">
                            {{ item.numb }}
                        </div>
                        <div v-if="!hideUpdate && item.id === updId">
                            <input v-model="form.numb" id="updPosition" class="h-8 bg-gray-50 border border-gray-600
                            text-gray-900 text-sm italic text-center rounded-lg focus:ring-blue-500 focus:border-blue-500
                            block w-full text-xs">
                            <p v-if="form.errors.numb" class="text-red-600 mb-2 italic">{{ form.errors.numb }}</p>
                        </div>
                    </td>
                    <td :class='["px-3 py-1.5 text-center", index%2 === 0 ? "" : "bg-gray-300"]'>
                        <div v-if="hideUpdate || !hideUpdate && item.id !== updId">
                            {{ item.element.title }}
                        </div>
                        <div v-if="!hideUpdate && item.id === updId" class="ml-10">
                            <select v-model="form.element_id" id="updPosition" class="bg-gray-50 border border-gray-600
                            text-gray-900 text-sm italic text-center rounded-lg focus:ring-blue-500
                            focus:border-blue-500 block w-44 h-8 text-xs">
                                <option v-for="element in elements" :value="element.id">{{ element.title }}</option>
                            </select>
                        </div>
                    </td>
                    <td :class='["px-6 py-1.5 text-center", index%2 === 0 ? "" : "bg-gray-300"]'>
                        <div v-if="hideUpdate || !hideUpdate && item.id !== updId">
                            {{ item.metal.title }} {{ item.characteristic.title }} {{ item.standard.title }}
                            {{ item.steel.title }}
                        </div>
                        <div v-if="!hideUpdate && item.id === updId" class="flex">
                            <select :key="form.metal_id" v-model="form.metal.title" id="updPosition" class="h-8 bg-gray-50 border border-gray-600
                            text-gray-900 text-sm italic text-center rounded-lg focus:ring-blue-500 focus:border-blue-500
                            w-full block text-xs">
<!--                                <option selected>{{ item.metal.title }}</option>>-->
                                <option v-for="metal in metals" key="{{ metal.id }}">{{ metal.title }}</option>
                            </select>
                            <select v-model="form.characteristic_id" id="updPosition" class="h-8 bg-gray-50 border border-gray-600
                            text-gray-900 text-sm italic text-center rounded-lg focus:ring-blue-500 focus:border-blue-500
                            w-full block text-xs">
                                <option v-for="characteristic in selectedCharacteristics">{{ characteristic.title }}</option>
                            </select>
                            <select v-model="form.standard_id" id="updPosition" class="h-8 bg-gray-50 border border-gray-600
                            text-gray-900 text-sm italic text-center rounded-lg focus:ring-blue-500 focus:border-blue-500
                            w-full block text-xs">
                                <option v-for="standard in selectedStandards">{{ standard.title }}</option>
                            </select>
                            <select v-model="form.steel_id" id="updPosition" class="h-8 bg-gray-50 border border-gray-600
                            text-gray-900 text-sm italic text-center rounded-lg focus:ring-blue-500 focus:border-blue-500
                            w-full block text-xs">
                                <option v-for="steel in steels">{{ steel.title }}</option>
                            </select>

                        </div>
                    </td>
                    <td :class='["px-2 py-1.5 text-center", index%2 === 0 ? "" : "bg-gray-300"]'>
                        <div v-if="hideUpdate || !hideUpdate && item.id !== updId">
                            {{ item.weight }} <span v-if="item.quantity"> ({{ item.quantity }} шт.)</span>
                        </div>
                        <div v-if="!hideUpdate && item.id === updId">
                            <input v-model="form.weight" id="updPosition" class="h-8 bg-gray-50 border border-gray-600
                            text-gray-900 text-sm italic text-center rounded-lg focus:ring-blue-500 focus:border-blue-500
                            block w-full text-xs">
                        </div>
                    </td>
                    <td :class='["px-2 py-1.5 text-center", index%2 === 0 ? "" : "bg-gray-300"]'>
                        <div class="ml-2">
                            <div v-if="hideUpdate || !hideUpdate && item.id !== updId"
                                 :class="[colors[item.paint_color]]">
                                <div :class="[item.paint_color === 'RAL 8002' ? 'text-white' : 'text-black']">
                                    {{ item.paint }} {{ item.paint_color }}
                                    <span v-if="item.paint_quantity"> - {{ item.paint_quantity }} кг</span>
                                </div>
                            </div>
                            <div v-if="!hideUpdate && item.id === updId" class="flex flex flex-wrap justify-center">
                                <select v-model="form.paint" id="updPosition" class="bg-gray-50 border border-gray-600
                            text-gray-900 text-sm italic text-center rounded-lg focus:ring-blue-500 focus:border-blue-500
                            block w-48 h-8 text-xs">
                                    <option class="text-center" v-for="paint in paints">{{ paint.title }}</option>
                                </select>
                                <select v-model="form.paint_color" id="updPosition" class="bg-gray-50 border border-gray-600
                            text-gray-900 text-sm italic text-center rounded-lg focus:ring-blue-500 focus:border-blue-500
                            block w-28 h-8 text-xs">
                                    <option :class="[value]" v-for="(value, color) in colors">{{ color }}</option>
                                </select>
                                <select v-model="form.number_of_layers" id="updPosition" class="bg-gray-50 border border-gray-600
                                text-gray-900 text-sm italic text-center rounded-lg focus:ring-blue-500 focus:border-blue-500
                                block w-20 h-8 text-xs">
                                    <option selected class="text-left">Слои</option>
                                    <option class="text-left" v-for="layer in layers">{{ layer }}</option>
                                </select>
                                <div class="flex ml-1 mt-2">
                                    <input type="checkbox" id="checkbox" v-model="form.is_pile">
                                    <label for="checkbox">Свая</label>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td :class='["px-2 py-1.5 text-center", index%2 === 0 ? "" : "bg-gray-300"]'>
                        <div v-if="hideUpdate && item.id !== updId || !hideUpdate && item.id !== updId">
                            <button v-if="!hideUpdate && item.id !== updId" @click.prevent="showUpdate(item)" disabled>
                                <UpdateButton :hide-update="hideUpdate"></UpdateButton>
                            </button>
                            <button v-if="hideUpdate && item.id !== updId" @click.prevent="showUpdate(item)">
                                <UpdateButton :hide-update="hideUpdate"></UpdateButton>
                            </button>
                        </div>
                        <div v-if="!hideUpdate && item.id === updId" class="flex justify-center">
                            <svg @click.prevent="submit" xmlns="http://www.w3.org/2000/svg" fill="none"
                                 viewBox="0 0 24 24" stroke-width="1.5" stroke="green" class="w-6 h-6 cursor-pointer">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                            </svg>
                            <svg @click.prevent="closeUpdate" xmlns="http://www.w3.org/2000/svg" fill="none"
                                 viewBox="0 0 24 24" stroke-width="1.5" stroke="red" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </div>
                    </td>
                    <td :class='["px-2 py-1.5 text-center", index%2 === 0 ? "" : "bg-gray-300"]'>
                        <DeleteButton :item="item" :path="'material'"></DeleteButton>
                    </td>
                </tr>
                </tbody>
                <tr class="relative sticky bottom-0">
                    <td class="text-center text-indigo-100 bg-indigo-500"></td>
                    <td class="text-center text-indigo-100 bg-indigo-500"></td>
                    <td class="text-indigo-100 bg-indigo-500">ИТОГО</td>
                    <td class="text-center text-indigo-100 bg-indigo-500">{{ selectedMaterialWeight.toFixed(2) }}т</td>
                    <td class="text-center text-indigo-100 bg-indigo-500"></td>
                    <td class="text-center text-indigo-100 bg-indigo-500">{{ selectedMaterialPaint.toFixed(2) }}кг</td>
                    <td class="text-center text-indigo-100 bg-indigo-500"></td>
                    <td class="text-center text-indigo-100 bg-indigo-500"></td>
                </tr>
            </table>
        </div>
        <MaterialStoreComponent
            :hide-material="hideMaterial" :project_id="project.id" :elements="elements"
            :metals="metals" :characteristics="characteristics" :standards="standards" :steels="steels"
            :units="units" @closeStore="closeStore">
        </MaterialStoreComponent>
<!--        <Link :href="route('all')">-->
<!--            Набивка материала-->
<!--        </Link>-->
    </UserLayout>
</template>

