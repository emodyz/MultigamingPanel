<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Users <span class="text-gray-400">/</span> Index
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex items-center justify-center bg-white overflow-hidden shadow-xl sm:rounded-lg">
                   <data-table :query-url="'/users'"
                               :query-param="'users'"
                               :headers="headers"
                               :data-object="users"
                               :initial-query="initialSearch"
                               :actions="actions"
                               :user-permissions="UserPermissions"
                               class="w-full p-6"></data-table>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script lang="ts">
import Pagination from "@/Shared/Pagination.vue";
import JetInput from "@/Jetstream/Input.vue";
import DataTable, {dataTableActionsOption} from "@/Shared/DataTable.vue";

import {Vue, Component, Prop} from 'vue-property-decorator'
import AppLayout from "@/Layouts/AppLayout.vue";


@Component({
    components: {
        AppLayout,
        DataTable,
        Pagination,
        JetInput,
    },
})
export default class UsersIndex extends Vue {
    @Prop() readonly users!: null | object
    @Prop() readonly initialSearch!: null | string
    @Prop() readonly UserPermissions!: Array<string> | null

    headers: Array<object> = [
        { title: '#', key: 'index', type: null },
        { title: 'Name', key: 'name' , type: null },
        { title: 'Email', key: 'email' , type: null },
        { title: 'Role', key: 'role' , type: null },
        { title: 'Registered', key: 'created_at' , type: 'Date.Formatted' },
        { title: 'Verified', key: 'email_verified_at' , type: 'Date.FromNow' },
    ]

    actions: dataTableActionsOption = {
        enabled: true,
        baseUrl: "/users",
        destroy: {displayName: 'Delete', bgColor: "red-500", color: "white", enabled: true},
        edit: {displayName: 'Edit', bgColor: "blue-500", color: "white", enabled: true, path: "edit"},
        show: {displayName: 'See', bgColor: "green-500", color: "white", enabled: true}
    }
}
</script>
