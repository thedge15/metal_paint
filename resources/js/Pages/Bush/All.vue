<script setup>

import UserLayout from "@/Layouts/UserLayout.vue";
import {Link, useForm} from "@inertiajs/vue3";
import {computed, onMounted, ref} from "vue";
import PaintFilter from "@/Components/PaintFilter.vue";
import ExportButton from "@/Components/ExportButton.vue";
import MaterialFilter from "@/Components/MaterialFilter.vue";
import ElementFilter from "@/Components/ElementFilter.vue";
import ProjectFilter from "@/Components/ProjectFilter.vue";
import {useSelected} from "@/Use/useSelected.js";
import {useFiltered} from "@/Use/useFiltered.js";
import UpdateButton from "@/Components/UpdateButton.vue";
import CreateButton from "@/Components/CreateButton.vue";
import MaterialStoreComponent from "@/Components/MaterialStoreComponent.vue";

const checkedMaterials = ref([]);
const hideMaterial = ref(false);
const hideUpdate = ref(true);
const selectedPaint = ref("Краска");
const selectedColor = ref("Цвет");
const selectedMaterial = ref("Наименование");
const selectedElement = ref('Конструктивный элемент');
const selectedProject = ref('РД');
const updId = ref();
const updProduct = ref();
const layers = ref([1, 2, 3]);

const props = defineProps({
    bush: {
        type: Object,
        default: () => ({}),
    },
    elements: {
        type: Array,
        default: () => ({}),
    },
    projects: {
        type: Array,
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
    materials: {
        type: Array,
        default: () => ({}),
    },
    projectsFilterCollection: {
        type: Array,
        default: () => ({}),
    },
    materialsFilterCollection: {
        type: Object,
        default: () => ({}),
    },
    elementsFilterCollection: {
        type: Array,
        default: () => ({}),
    },
    paints: {
        type: Array,
        default: () => ({})
    },
    colors: {
        type: Object,
        default: () => ({})
    },
    standards: {
        type: Object,
        default: () => ({})
    },
    steels: {
        type: Object,
        default: () => ({})
    },
    units: {
        type: Array,
        default: () => ([])
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
const filterMaterial = (data) => {
    selectedMaterial.value = data
}
const filterElement = (data) => {
    selectedElement.value = data
}
const filterProject = (data) => {
    selectedProject.value = data
}

const form = useForm({
    id: '',
    numb: '',
    weight: '',
    paint: '',
    paint_color: '',
    number_of_layers: '',
    is_pile: '',
})
const showUpdate = (item) => {
    hideUpdate.value = !hideUpdate.value
    updProduct.value = item
    updId.value = item.id
    form.id = item.id
    form.numb = item.numb
    form.weight = item.weight
    form.paint = item.paint
    form.paint_color = item.paint_color
    form.number_of_layers = item.number_of_layers
    form.is_pile = Boolean(item.is_pile)
}
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
    form.clearErrors()
}

const allSelectedMaterials = useSelected(props.materials, checkedMaterials)
const selectedArray = computed(() => {
    let filterArray = selectedMaterial.value === 'Наименование' ? props.materials :
        props.materials.filter(item => item.metal.title + ' ' + item.characteristic.title === selectedMaterial.value);

    filterArray = selectedElement.value === 'Конструктивный элемент' ? filterArray :
        filterArray.filter(item => item.element.title === selectedElement.value);

    filterArray = selectedProject.value === 'РД' ? filterArray :
        filterArray.filter(item => item.project.title === selectedProject.value);

    if (selectedPaint.value !== "Краска" && selectedColor.value === "Цвет") {
        filterArray = filterArray.filter(item => item.paint === selectedPaint.value);
    }
    if (selectedPaint.value === "Краска" && selectedColor.value !== "Цвет") {
        filterArray = filterArray.filter(item => item.paint_color === selectedColor.value);
    }
    if (selectedPaint.value !== "Краска" && selectedColor.value !== "Цвет") {
        filterArray = filterArray.filter(item => item.paint === selectedPaint.value).filter(item => item.paint_color === selectedColor.value);
    }
    return filterArray
})

const selectAll = computed({
    get() {
        return selectedArray ? checkedMaterials.value.length === selectedArray.value.length : false;
    },
    set(value) {
        const selected = [];
        if (value) {
            selectedArray.value.forEach(function (material) {
                selected.push(material.id);
            });
        }
        checkedMaterials.value = selected;
    }
})

const showResult = () => {
    console.log(props.elements);
};
</script>

<template>
    <UserLayout>
        <div v-if="bush" class="text-center italic">
            <Link :href="route('index.bush')">
                {{ bush.title }}
            </Link>
        </div>
<!--        <a @click.prevent="showResult">Жмякай</a>-->
<!--        {{ materials }}-->
        <div class="flex justify-between">
            <CreateButton @closeStore="closeStore" :disabled="hideMaterial"></CreateButton>
            <ExportButton :export-route="'export.bush'" :export-element="bush"></ExportButton>
        </div>
        <!-- component -->
        <div class="flex-grow overflow-auto">
            <table class="relative w-full border mb-3 text-xs table-fixed">
                <thead>
                <tr>
                    <th class="w-6"><input type="checkbox" v-model="selectAll"></th>
                    <th class="w-16">№ РФ</th>
                    <th class="w-48">
                        <ProjectFilter :filter-collection="projectsFilterCollection"
                                       :column-name="'РД'"
                                       @filterProject="filterProject" />
                    </th>
                    <th class="w-64">
                        <ElementFilter :filter-collection="elementsFilterCollection"
                                       :column-name="'Конструктивный элемент'"
                                       @filterElement="filterElement" />
                    </th>
                    <th>
                        <MaterialFilter :filter-collection="materialsFilterCollection" :column-name="'Наименование'"
                                        @filterMaterial="filterMaterial" />
                    </th>
                    <th class="w-28">Количество, т</th>
                    <th class="w-128">
                        <PaintFilter :paints="paints" :colors="colors" @filterPaint="filterPaint"
                                     @filterColor="filterColor" />
                    </th>
                    <th class="w-28">Редактирование</th>
                </tr>
                </thead>
                <tbody class="divide-y bg-gray-100 font-[Poppins]">
                <tr v-for="(item, index) in selectedArray">
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
                    <td :class='["px-2 py-1.5 text-center", index%2 === 0 ? "" : "bg-gray-300"]'>
                        {{ item.project.title }}
                    </td>
                    <td :class='["px-3 py-1.5 text-center", index%2 === 0 ? "" : "bg-gray-300"]'>
                        {{ item.element.title }}
                    </td>
                    <td :class='["px-6 py-1.5 text-center", index%2 === 0 ? "" : "bg-gray-300"]'>
                        {{ item.metal.title }} {{ item.characteristic.title }} {{ item.standard.title }}
                        {{ item.steel.title }}
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
                </tr>
                </tbody>
                <tr class="relative sticky bottom-0">
                    <td class="text-center text-indigo-100 bg-indigo-500"></td>
                    <td class="text-center text-indigo-100 bg-indigo-500"></td>
                    <td class="text-center text-indigo-100 bg-indigo-500"></td>
                    <td class="text-center text-indigo-100 bg-indigo-500"></td>
                    <td class="text-indigo-100 bg-indigo-500">ИТОГО</td>
                    <td class="text-center text-indigo-100 bg-indigo-500">{{ allSelectedMaterials.selectedMaterialWeight.value.toFixed(2) }}т</td>
                    <td class="text-center text-indigo-100 bg-indigo-500">{{ allSelectedMaterials.selectedMaterialPaint.value.toFixed(2) }}кг</td>
                    <td class="text-center text-indigo-100 bg-indigo-500"></td>
                </tr>
            </table>
        </div>
        <MaterialStoreComponent
            :hide-material="hideMaterial" :elements="props.elements" :projects="props.projects"
            :metals="metals" :characteristics="props.characteristics" :standards="props.standards" :steels="props.steels"
            :units="units" @closeStore="closeStore">
        </MaterialStoreComponent>
    </UserLayout>
</template>

