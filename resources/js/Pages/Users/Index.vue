<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Users <span class="text-gray-400">/</span> Index
            </h2>
        </template>

        <!--
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="flex items-center justify-center bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    </div>
            </div>
        </div>
        -->


        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <data-table
                    :query-url="'/users'"
                    :query-param="'users'"
                    :headers="headers"
                    :data-object="users"
                    :initial-query="initialSearch"
                    :actions="actions"
                    :user-permissions="UserPermissions"
                    class="w-full p-6">
                </data-table>
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
        { title: '#', key: 'index', type: 'Index' },
        { title: 'Name', key: 'name' , type: 'User.Profile' },
        // { title: 'Email', key: 'email' , type: null },
        { title: 'Role', key: 'roleName' , type: null },
        { title: 'Status', key: 'email_verified_at' , type: 'User.Status' },
        { title: 'Registered', key: 'created_at' , type: 'Date.Formatted' },
    ]

    actions: dataTableActionsOption = {
        enabled: true,
        baseUrl: "/users",
        destroy: {displayName: 'Delete', hvColor: "red-900", color: "red-600", enabled: true},
        edit: {displayName: 'Edit', hvColor: "indigo-900", color: "indigo-600", enabled: true, path: "edit"},
        show: {displayName: 'See', hvColor: "green-900", color: "green-600", enabled: true}
    }
}
</script>
