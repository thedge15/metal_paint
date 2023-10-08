<script setup>
import {Link, useForm} from "@inertiajs/vue3";
import UserLayout from "@/Layouts/UserLayout.vue";
import CreateButton from "@/Components/CreateButton.vue";
import ShowButton from "@/Components/ShowButton.vue";
import UpdateButton from "@/Components/UpdateButton.vue";
import DeleteButton from "@/Components/DeleteButton.vue";
import StoreComponent from "@/Components/StoreComponent.vue";
import {ref} from "vue";
import ExportButton from "@/Components/ExportButton.vue";

const hideMaterial = ref(false);
const hideUpdate = ref(true);
const updId = ref();
const updTitle = ref();
const updChange = ref();

const props = defineProps({
    projects: {
        type: Array,
        default: () => ({}),
    },
    bush: {}
})

const closeStore = () => {
    hideMaterial.value = !hideMaterial.value
}

const showUpdate = (item) => {
    hideUpdate.value = !hideUpdate.value;
    updId.value = item.id;
    form.title = item.title;
    form.change = item.change;
}

const form = useForm({
    title: updTitle.value,
    change: updChange.value,
})
const submit = () => {
    form.put(route('update.project', updId.value))
    closeUpdate()
}
const closeUpdate = () => {
    hideUpdate.value = !hideUpdate.value
    updId.value = null
    form.reset()
}
</script>
<template>
    <UserLayout>
        <div v-if="bush" class="text-center italic">
            <Link :href="route('index.bush')">
                КГС {{ bush.title }}
            </Link>
        </div>
        <div class="flex flex-col h-screen">
            <div :class="[$page.props.auth.user['is_admin'] === 1 ? '' : 'hidden']">
                <div class="flex justify-between">
                    <CreateButton @closeStore="closeStore" :disabled="hideMaterial"></CreateButton>
                    <ExportButton :export-route="'export.bush'" :export-element="bush"></ExportButton>
                </div>
            </div>
            <div :class="['flex-grow overflow-auto', $page.props.auth.user['is_admin'] === 1 ? '' : 'mt-5']">
                <table class="relative w-full border mb-3 text-xs table-fixed">
                    <thead>
                    <tr>
                        <th class="sticky top-0 px-6 py-3 text-indigo-100 bg-indigo-500 w-4">№</th>
                        <th class="sticky top-0 px-6 py-3 text-indigo-100 bg-indigo-500">Наименование раздела РД</th>
                        <th class="sticky top-0 px-6 py-3 text-indigo-100 bg-indigo-500">изм.</th>
                        <th class="sticky top-0 px-6 py-3 text-indigo-100 bg-indigo-500">Просмотр</th>
                        <th v-if="$page.props.auth.user['is_admin'] === 1"
                            class="sticky top-0 px-6 py-3 text-indigo-100 bg-indigo-500">Редактирование
                        </th>
                        <th v-if="$page.props.auth.user['is_admin'] === 1"
                            class="sticky top-0 px-6 py-3 text-indigo-100 bg-indigo-500">Удаление
                        </th>
                    </tr>
                    </thead>
                    <tbody class="divide-y bg-gray-100">
                    <tr v-for="(item, index) in projects">
                        <td :class='["px-6 py-2 text-center", index%2 === 0 ? "" : "bg-gray-300"]'>{{ index + 1 }}</td>
                        <td :class='["px-6 py-2 text-center", index%2 === 0 ? "" : "bg-gray-300"]'>
                            <div v-if="hideUpdate || !hideUpdate && item.id !== updId">
                                {{ item.title }}
                            </div>
                            <div v-if="!hideUpdate && item.id === updId">
                                <input v-model="form.title" id="updPosition" class="h-8 bg-gray-50 border border-gray-600
                            text-gray-900 text-sm italic text-center rounded-lg focus:ring-blue-500 focus:border-blue-500
                            w-full h-4 block text-xs">
                            </div>
                        </td>
                        <td :class='["px-6 py-2 text-center", index%2 === 0 ? "" : "bg-gray-300"]'>
                            <div v-if="hideUpdate || !hideUpdate && item.id !== updId">
                                {{ item.change }}
                            </div>
                            <div v-if="!hideUpdate && item.id === updId">
                                <input v-model="form.change" id="updPosition" class="h-8 bg-gray-50 border border-gray-600
                            text-gray-900 text-sm italic text-center rounded-lg focus:ring-blue-500 focus:border-blue-500
                            w-full block text-xs">
                            </div>
                        </td>
                        <td :class='["px-6 py-2 text-center", index%2 === 0 ? "" : "bg-gray-300"]'>
                            <Link :href="route('index.material', item.id)">
                                <ShowButton></ShowButton>
                            </Link>
                        </td>
                        <td v-if="$page.props.auth.user['is_admin'] === 1"
                            :class='["px-6 py-2 text-center", index%2 === 0 ? "" : "bg-gray-300"]'>
                            <div v-if="hideUpdate && item.id !== updId || !hideUpdate && item.id !== updId">
                                <button v-if="!hideUpdate && item.id !== updId"
                                        @click.prevent="showUpdate(item)" disabled>
                                    <UpdateButton :hide-update="hideUpdate"></UpdateButton>
                                </button>
                                <button v-if="hideUpdate && item.id !== updId"
                                        @click.prevent="showUpdate(item)">
                                    <UpdateButton :hide-update="hideUpdate"></UpdateButton>
                                </button>
                            </div>
                            <div v-if="!hideUpdate && item.id === updId" class="flex justify-center">
                                <svg @click.prevent="submit" xmlns="http://www.w3.org/2000/svg"
                                     fill="none"
                                     viewBox="0 0 24 24" stroke-width="1.5" stroke="green"
                                     class="w-6 h-6 cursor-pointer">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                                </svg>
                                <svg @click.prevent="closeUpdate" xmlns="http://www.w3.org/2000/svg" fill="none"
                                     viewBox="0 0 24 24" stroke-width="1.5" stroke="red" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </div>
                        </td>
                        <td v-if="$page.props.auth.user['is_admin'] === 1"
                            :class='["px-6 py-2 text-center", index%2 === 0 ? "" : "bg-gray-300"]'>
                            <DeleteButton :item="item" :path="'project'"></DeleteButton>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <StoreComponent :hide-material="hideMaterial" :element="'project'" :element-title="'раздела'"
                                :bush_id="bush.id" @closeStore="closeStore"></StoreComponent>
            </div>
        </div>
    </UserLayout>
</template>
