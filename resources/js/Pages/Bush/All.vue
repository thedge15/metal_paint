<script setup>

import UserLayout from "@/Layouts/UserLayout.vue";
import {Link, useForm} from "@inertiajs/vue3";
import {computed, ref} from "vue";
import PaintFilter from "@/Components/PaintFilter.vue";
import ExportButton from "@/Components/ExportButton.vue";
import MaterialFilter from "@/Components/MaterialFilter.vue";
import ElementFilter from "@/Components/ElementFilter.vue";

const checkedMaterials = ref([]);
const hideMaterial = ref(false);
const hideUpdate = ref(true);
const selectedPaint = ref("Краска");
const selectedColor = ref("Цвет");
const selectedMaterial = ref("Наименование");
const selectedElement = ref("Конструктивный элемент");

const updId = ref();

const updTitle = ref();

const props = defineProps({
    bush: Object,
    materials: {
        type: Array,
        default: () => ({}),
    },
    materialsFilterCollection: {
        type: Array,
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

    let filterArray = selectedMaterial.value === 'Наименование' ? props.materials :
        props.materials.filter(item => item.title === selectedMaterial.value);

    filterArray = selectedElement.value === 'Конструктивный элемент' ? filterArray :
        filterArray.filter(item => item.element === selectedElement.value);

    if (selectedPaint.value !== "Краска" && selectedColor.value === "Цвет") {
        filterArray = filterArray.filter(item => item.paint === selectedPaint.value);
    }
    if (selectedPaint.value === "Краска" && selectedColor.value !== "Цвет") {
        filterArray = filterArray.filter(item => item.paint_color === selectedColor.value);
    }
    if (selectedPaint.value !== "Краска" && selectedColor.value !== "Цвет") {
        filterArray = filterArray.filter(item => item.paint === selectedPaint.value).filter(item => item.paint_color === selectedColor.value);
    }

    return filterArray;
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
        <div v-if="bush" class="text-center italic">
            <Link :href="route('index.bush')">
                {{ bush.title }}
            </Link>
        </div>
        <div class="flex justify-between">
            <ExportButton :export-route="'export.bush'" :export-element="bush"></ExportButton>
        </div>
        <!-- component -->
        <div class="flex-grow overflow-auto">
            <table class="relative w-full border mb-3 text-xs table-fixed">
                <thead>
                <tr>
                    <th class="w-6"><input type="checkbox" v-model="selectAll"></th>
                    <th class="w-16">№ РФ</th>
                    <th class="w-64">
                        <ElementFilter :filter-collection="elementsFilterCollection" :column-name="'Конструктивный элемент'"
                                        @filterElement="filterElement"></ElementFilter>
                    </th>
                    <th>
                        <MaterialFilter :filter-collection="materialsFilterCollection" :column-name="'Наименование'"
                        @filterMaterial="filterMaterial"></MaterialFilter>
                    </th>
                    <th class="w-28">Количество, т</th>
                    <th class="w-128">
                        <PaintFilter :paints="paints" :colors="colors" @filterPaint="filterPaint"
                                     @filterColor="filterColor"/>
                    </th>
                </tr>
                </thead>
                <tbody class="divide-y bg-gray-100 font-[Poppins]">
                <tr v-for="(item, index) in selectedPaintArray">
                    <td :class='["px-2 py-1.5 text-center", index%2 === 0 ? "" : "bg-gray-300"]'>
                        <input type="checkbox" :value="item.id" v-model="checkedMaterials">
                        <span class="hidden">{{ item.id }}</span>
                    </td>
                    <td :class='["px-2 py-1.5 text-center", index%2 === 0 ? "" : "bg-gray-300"]'>
                        {{ item['numb'] }}
                    </td>
                    <td :class='["px-3 py-1.5 text-center", index%2 === 0 ? "" : "bg-gray-300"]'>
                        {{ item.element }}
                    </td>
                    <td :class='["px-6 py-1.5 text-center", index%2 === 0 ? "" : "bg-gray-300"]'>
                        {{ item.title }} {{ item.standard }} {{ item.steel }}
                    </td>
                    <td :class='["px-2 py-1.5 text-center", index%2 === 0 ? "" : "bg-gray-300"]'>
                        {{ item.weight }} <span v-if="item.quantity"> ({{ item.quantity }} шт.)</span>
                    </td>
                    <td :class='["px-2 py-1.5 text-center", index%2 === 0 ? "" : "bg-gray-300"]'>
                        <div class="ml-2">
                            <div :class="[colors[item.paint_color]]">
                                <div :class="[item.paint_color === 'RAL 8002' ? 'text-white' : 'text-black']">
                                    {{ item.paint }} {{ item.paint_color }}
                                    <span v-if="item.paint_quantity"> - {{ item.paint_quantity }} кг</span>
                                </div>
                            </div>
                        </div>
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
                </tr>
            </table>
        </div>
    </UserLayout>
</template>

