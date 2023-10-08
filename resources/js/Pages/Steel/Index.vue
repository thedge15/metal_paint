<script setup>
import UserLayout from "@/Layouts/UserLayout.vue";
import CreateButton from "@/Components/CreateButton.vue";
import UpdateButton from "@/Components/UpdateButton.vue";
import DeleteButton from "@/Components/DeleteButton.vue";
import StoreComponent from "@/Components/StoreComponent.vue";
import {ref} from "vue";
import {useForm} from "@inertiajs/vue3";

const hideMaterial = ref(false)
const hideUpdate = ref(true);
const updId = ref();
const updTitle = ref();

const columnHeaders = ['Наименование стали', 'Редактирование', 'Удаление']

const props = defineProps({
    steels: {
        type: Array,
        default: () => ({}),
    },
})
const closeStore = () => {
    hideMaterial.value = !hideMaterial.value
}
const showUpdate = (item) => {
    hideUpdate.value = !hideUpdate.value
    updId.value = item.id;
    form.title = item.title;
}

const form = useForm({
    title: updTitle.value,
})

const submit = () => {
    form.put(route('update.steel', updId.value))
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
        <p class="text-center italic">Сталь</p>
        <CreateButton @closeStore="closeStore" :disabled="hideMaterial"></CreateButton>
        <!-- component -->
        <div class="flex-grow overflow-auto">
            <table class="relative w-full border mb-3 table-fixed">
                <thead>
                <tr>
                    <th class="sticky top-0 px-6 py-3 text-indigo-100 bg-indigo-500 w-6">№</th>
                    <th v-for="columnName in columnHeaders"
                        class="sticky top-0 px-6 py-3 text-indigo-100 bg-indigo-500">{{ columnName }}
                    </th>
                </tr>
                </thead>
                <tbody class="divide-y bg-gray-100">
                <tr v-for="(item, index) in steels">
                    <td :class='["px-6 py-2 text-center", index%2 === 0 ? "" : "bg-gray-300"]'>{{ index + 1 }}</td>
                    <td :class='["px-6 py-2 text-center", index%2 === 0 ? "" : "bg-gray-300"]'>
                        <div v-if="hideUpdate || !hideUpdate && item.id !== updId">
                            {{ item.title }}
                        </div>
                        <div v-if="!hideUpdate && item.id === updId">
                            <input v-model="form.title" id="updPosition" class="h-8 bg-gray-50 border border-gray-600
                            text-gray-900 text-sm italic text-center rounded-lg focus:ring-blue-500 focus:border-blue-500
                            w-full block text-xs">
                        </div>
                    </td>
                    <td :class='["px-2 py-1.5 text-center", index%2 === 0 ? "" : "bg-gray-300"]'>
                        <div
                            v-if="hideUpdate && item.id !== updId || !hideUpdate && item.id !== updId">
                            <button v-if="!hideUpdate && item.id !== updId" @click.prevent="showUpdate(item)"
                                    disabled>
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
                    <td :class='["px-6 py-2 text-center", index%2 === 0 ? "" : "bg-gray-300"]'>
                        <DeleteButton :item="item" :path="'steel'"></DeleteButton>
                    </td>
                </tr>
                </tbody>
            </table>
            <StoreComponent :hide-material="hideMaterial" :element="'steel'" :element-title="'марки стали'"
                            @closeStore="closeStore"></StoreComponent>
        </div>
    </UserLayout>
</template>

