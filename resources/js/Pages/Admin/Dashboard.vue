<template>
    <admin-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Admin <span class="text-gray-400">/</span> Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex items-center justify-center bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="w-full p-6">
                        <jet-input class="w-1/4" type="search" placeholder="Search..." v-model="search"></jet-input>
                        <table class="w-full table-auto">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2">Name</th>
                                    <th class="px-4 py-2">Email</th>
                                    <th class="px-4 py-2">Role</th>
                                    <th class="px-4 py-2">Registered on</th>
                                    <th class="px-4 py-2">Verified</th>
                                    <th class="px-4 py-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="user in users.data" :key="user.id">
                                    <td class="border px-4 py-2">{{ user.name }}</td>
                                    <td class="border px-4 py-2">{{ user.email }}</td>
                                    <td class="border px-4 py-2">{{ user.role }}</td>
                                    <td class="border px-4 py-2">{{ $moment( user.created_at).format('LLL') }}</td>
                                    <td class="border px-4 py-2">{{ $moment(user.email_verified_at).fromNow() }}</td>
                                    <td class="border px-4 py-2">None</td>
                                </tr>
                            </tbody>
                        </table>
                        <pagination class="justify-self-start" :links="users.links"></pagination>
                    </div>
                </div>
            </div>
        </div>
    </admin-layout>
</template>

<script lang="ts">
import AdminLayout from '@/Layouts/AdminLayout.vue'
import Pagination from "@/Shared/Pagination.vue";
import JetInput from "@/Jetstream/Input.vue";

import {Vue, Component, Prop, Watch} from 'vue-property-decorator'

import { Inertia } from "@inertiajs/inertia";
import debounce from 'lodash/debounce';
import { stringify } from 'qs';


@Component({
    components: {
        AdminLayout,
        Pagination,
        JetInput,
    },
})
export default class AdminDashboard extends Vue {
    @Prop() readonly users!: null | object
    @Prop() readonly initialSearch!: null | string
    @Prop() readonly CerberusCan!: Array<string> | null

    @Watch('search')
    onSearchChanged = debounce((val, old) => {
        const query = stringify({
            search: val || undefined,
        });
        Inertia.visit(query ? `/admin/dashboard?${query}` : '/admin/dashboard', {
            preserveScroll: true,
            preserveState: true,
            only: ['users'],
        });
    }, 250)

    created() {
        console.log(this.users)
    }

    search = this.initialSearch
}
</script>
