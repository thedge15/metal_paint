<script setup>
import UserLayout from "@/Layouts/UserLayout.vue";

const props = defineProps({
    users: {
        type: Array,
        default: () => ({}),
    }
})
</script>
<template>
    <UserLayout>
        <div :class="['flex-grow overflow-auto', $page.props.auth.user['is_admin'] === 1 ? '' : 'mt-5']">
            <table class="relative w-full border mb-3 text-xs table-fixed">
                <thead>
                <tr>
                    <th class="sticky top-0 px-6 py-3 text-indigo-100 bg-indigo-500 w-4">№</th>
                    <th class="sticky top-0 px-6 py-3 text-indigo-100 bg-indigo-500">Имя</th>
                    <th class="sticky top-0 px-6 py-3 text-indigo-100 bg-indigo-500">Эл. почта</th>
                    <th class="sticky top-0 px-6 py-3 text-indigo-100 bg-indigo-500">Последнее появление</th>
                    <th class="sticky top-0 px-6 py-3 text-indigo-100 bg-indigo-500">Статус</th>
                </tr>
                </thead>
                <tbody class="divide-y bg-gray-100">
                <tr v-for="(item, index) in users">
                    <td :class='["px-6 py-2 text-center", index%2 === 0 ? "" : "bg-gray-300"]'>{{ index + 1 }}</td>
                    <td :class='["px-6 py-2 text-center", index%2 === 0 ? "" : "bg-gray-300"]'>{{ item.name }}</td>
                    <td :class='["px-6 py-2 text-center", index%2 === 0 ? "" : "bg-gray-300"]'>{{ item.email }}</td>
                    <td :class='["px-6 py-2 text-center", index%2 === 0 ? "" : "bg-gray-300"]'>{{ item.last_seen }}</td>
                    <td :class='["px-6 py-2 text-center", index%2 === 0 ? "" : "bg-gray-300"]'>
                        <span :class="[item.status === 'online' ? 'text-lime-600 text-lg' : '']">{{ item.status }}</span>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </UserLayout>
</template>
