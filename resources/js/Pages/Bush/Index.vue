<script setup>
import UserLayout from "@/Layouts/UserLayout.vue";
import CreateButton from "@/Components/CreateButton.vue";
import ShowButton from "@/Components/ShowButton.vue";
import DeleteButton from "@/Components/DeleteButton.vue";
import StoreComponent from "@/Components/StoreComponent.vue";
import {ref} from "vue";
import {Link, router, useForm} from "@inertiajs/vue3";

const hideMaterial = ref(false)
const hideUpdate = ref(true);
const updId = ref();
const updTitle = ref();
const closeStore = () => {
    hideMaterial.value = !hideMaterial.value
}

const props = defineProps({
    bushes: {
        type: Array,
        default: () => ({}),
    },
})

const form = useForm({
    title: updTitle.value,
})
</script>

<template>
    <UserLayout>
        <p class="text-center italic">КГС</p>
        <div :class="[$page.props.auth.user['is_admin'] === 1 ? '' : 'hidden']">
            <CreateButton @closeStore="closeStore" :disabled="hideMaterial"></CreateButton>
        </div>
        <div :class="['flex-grow overflow-auto', $page.props.auth.user['is_admin'] === 1 ? '' : 'mt-5']">
            <table class="relative w-full border mb-3">
                <thead>
                <tr>
                    <th class="sticky top-0 px-6 py-3 text-indigo-100 bg-indigo-500">№</th>
                    <th class="sticky top-0 px-6 py-3 text-indigo-100 bg-indigo-500">Наименование куста</th>
                    <th class="sticky top-0 px-6 py-3 text-indigo-100 bg-indigo-500">Разделы</th>
                    <th class="sticky top-0 px-6 py-3 text-indigo-100 bg-indigo-500">Материапы</th>
                    <th v-if="$page.props.auth.user['is_admin'] === 1"
                        class="sticky top-0 px-6 py-3 text-indigo-100 bg-indigo-500">Удаление
                    </th>
                </tr>
                </thead>
                <tbody class="divide-y bg-gray-100">
                <tr v-for="(item, index) in bushes">
                    <td :class='["px-6 py-2 text-center", index%2 === 0 ? "" : "bg-gray-300"]'>{{ index + 1 }}</td>
                    <td :class='["px-6 py-2 text-center", index%2 === 0 ? "" : "bg-gray-300"]'>{{ item.title }}</td>
                    <td :class='["px-6 py-2 text-center", index%2 === 0 ? "" : "bg-gray-300"]'>
                        <Link :href="route('show.bush', item.id)">
                            <ShowButton />
                        </Link>
                    </td>
                    <td :class='["px-6 py-2 text-center", index%2 === 0 ? "" : "bg-gray-300"]'>
                        <Link :href="route('all.bush', item.id)">
                            <ShowButton />
                        </Link>
                    </td>
                    <td v-if="$page.props.auth.user['is_admin'] === 1"
                        :class='["px-6 py-2 text-center", index%2 === 0 ? "" : "bg-gray-300"]'>
                        <DeleteButton :item="item" :path="'bush'"></DeleteButton>
                    </td>
                </tr>
                </tbody>
            </table>
            <StoreComponent :hide-material="hideMaterial" :element="'bush'" :element-title="'куста'"
                            @closeStore="closeStore"></StoreComponent>
        </div>
    </UserLayout>
</template>


