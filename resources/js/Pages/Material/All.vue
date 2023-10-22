<script setup>
import AuthenticatedLayout from "../../Layouts/AuthenticatedLayout.vue";

const props = defineProps({
    projects: Array,
    bushes: Array,
    elements: Array,
    metals: Array,
    materials: Array,
    characteristics: Array,
    standards: Array,
    steels: Array,
    paints: Array,
})

</script>

<template>
    <AuthenticatedLayout>
        <div>
            <div class="px-6">
                <div v-for="bush in bushes">
                    <p>
                        Bush::create([
                        'title' => '{{ bush.title }}',
                        ])
                    </p>
                </div>
            </div>
            <div class="px-6">
                <div v-for="item in projects">
                    <p>Project::create(['bush_id' => {{ item.bush_id }}, 'title' => '{{ item.title }}', 'change' =>
                        {{ item.change }}])</p>
                </div>
            </div>
            <div class="px-6">
                <div v-for="item in elements">
                    <p>Element::create(['title' => '{{ item.title }}'])</p>
                </div>
            </div>
            <div class="px-6">
                <div v-for="item in metals">
                    <p>Metal::create(['title' => '{{ item.title }}'])</p>
                </div>
            </div>
            <div class="px-6">
                <div v-for="item in characteristics">
                    <p>Characteristic::create([
                        'metal_id' => '{{ item.metal_id }}',
                        'title' => '{{ item.title }}',
                        <span v-if="item.ton_length">'ton_length' => {{ item.ton_length }},
                        </span>'ton_area' => {{ item.ton_area }}])</p>
                </div>
            </div>
            <div class="px-6">
                <div v-for="item in standards">
                    <p>Standard::create(['metal_id' => {{ item.metal_id }}, 'title' => '{{ item.title }}'])</p>
                </div>
            </div>
            <div class="px-6">
                <div v-for="item in steels">
                    <p>Steel::create(['title' => '{{ item.title }}'])</p>
                </div>
            </div>
            <div class="px-6">
                <div v-for="item in paints">
                    <p>Paint::create(['title' => '{{ item.title }}', 'consumption' => '{{ item.consumption }}'])</p>
                </div>
            </div>
            <div class="px-6">
                <div v-for="material in materials">
                    <p>
                        Material::create([
                        <span v-if="material.numb">'numb' => '{{ material.numb }}',</span>
                        'project_id' => '{{ material.project_id }}',
                        <span v-if="material.element_id">'element_id' => '{{ material.element_id }}',</span>
                        'metal_id' => '{{ material.metal_id }}',
                        'characteristic_id' => '{{ material.characteristic_id }}',
                        'standard_id' => '{{ material.standard_id }}',
                        'steel_id' => '{{ material.steel_id }}',
                        'weight' => '{{ material.weight }}',
                        <span v-if="material.length">'length' => '{{ material.length }}',</span>
                        'area' => '{{ material.area }}',
                        <span v-if="material.quantity">'quantity' => '{{ material.quantity }}',</span>
                        <span v-if="material.paint">'paint' => '{{ material.paint }}',</span>
                        <span v-if="material.paint_quantity">'paint_quantity' => '{{ material.paint_quantity }}',</span>
                        <span v-if="material.paint_color">'paint_color' => '{{ material.paint_color }}',</span>
                        <span v-if="material.number_of_layers">'number_of_layers' => '{{ material.number_of_layers }}',</span>
                        <span v-if="material.is_pile">'is_pile' => '{{ material.is_pile }}',</span>
                        ])
                    </p>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

