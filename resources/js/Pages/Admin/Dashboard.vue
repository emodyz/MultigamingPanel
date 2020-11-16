<template>
    <admin-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Admin <span class="text-gray-400">/</span> Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <table class="table-auto">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">Name</th>
                                <th class="px-4 py-2">Email</th>
                                <th class="px-4 py-2">Role</th>
                                <th class="px-4 py-2">Verified</th>
                                <th class="px-4 py-2">Registered on</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="user in users">
                                <td class="border px-4 py-2">{{ user.name }}</td>
                                <td class="border px-4 py-2">{{ user.email }}</td>
                                <td class="border px-4 py-2">{{ user.role }}</td>
                                <td class="border px-4 py-2">{{ $moment(user.email_verified_at, 'YYYYMMDD').fromNow() }}</td>
                                <td class="border px-4 py-2">{{ user.created_at }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </admin-layout>
</template>

<script lang="ts">
import AdminLayout from '@/Layouts/AdminLayout.vue'
import Welcome from '@/Jetstream/Welcome.vue'

import {Vue, Component, Prop} from 'vue-property-decorator'

@Component({
    components: {
        AdminLayout,
        Welcome,
    },
})
export default class AdminDashboard extends Vue {
    @Prop() readonly users!: Array<null> | Array<Object>
    @Prop() readonly CerberusCan!: Array<string> | null

    created() {
        console.log(this.users)
    }
}
</script>
