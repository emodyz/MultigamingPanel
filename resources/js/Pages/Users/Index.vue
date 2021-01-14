<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Users <span class="text-gray-400">/</span> Index
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <data-table
            :query-url="'/users'"
            :query-param="'users'"
            :headers="headers"
            :data-object="users"
            data-type="Users"
            :initial-query="initialSearch"
            :actions="actions"
            :total-item-count="totalItemCount"
            class="w-full p-6"
        />
      </div>
    </div>
  </app-layout>
</template>

<script lang="ts">
import Pagination from '@/Shared/Pagination/Pagination.vue'
import JetInput from '@/Jetstream/Input.vue'
import DataTable from '@/Shared/DataTable/DataTable.vue'

import { Vue, Component, Prop } from 'vue-property-decorator'
import AppLayout from '@/Layouts/AppLayout.vue'
import { DataTableActionsOptions } from '@/Shared/DataTable/Types/DataTableActionsOptions'
import { DataTableHeader } from '@/Shared/DataTable/Types/DataTableHeader'

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

  @Prop() readonly totalItemCount!: null | number

  @Prop() readonly initialSearch!: null | string

  headers: Array<DataTableHeader> = [
    {
      title: '#',
      key: 'index',
      type: 'Index',
    },
    {
      title: 'Name',
      key: 'name',
      type: 'User.Profile',
      dataAccessors: {
        name: 'name',
        email: 'email',
        profile_photo_url: 'profile_photo_url',
      },
    },
    {
      title: 'Role',
      key: 'roleName',
    },
    {
      title: 'Status',
      key: 'email_verified_at',
      type: 'User.Status',
    },
    {
      title: 'Registered',
      key: 'created_at',
      type: 'Date.Formatted',
    },
  ]

  actions: DataTableActionsOptions = {
    enabled: true,
    baseUrl: '/users',
    actions: [
      {
        displayName: 'Edit',
        enabled: true,
        path: 'edit',
        permission: 'users-edit',
        type: 'edit',
        class: 'text-indigo-600 hover:text-indigo-900',
      },
      {
        displayName: 'Delete',
        enabled: true,
        permission: 'users-destroy',
        type: 'destroy',
        class: 'text-red-600 hover:text-red-900',
      },
    ],
  }

  created() {
    //
  }
}
</script>
