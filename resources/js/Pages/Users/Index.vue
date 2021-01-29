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
import DeleteUser from '@/Shared/DataTable/Components/Dialogs/DeleteUser.vue'
import DtDate from '@/Shared/DataTable/Components/Date.vue'
import DtUserProfile from '@/Shared/DataTable/Components/UserProfile.vue'
import DtUserStatus from '@/Shared/DataTable/Components/UserStatus.vue'

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
      component: 'Index',
    },
    {
      title: 'Name',
      key: 'name',
      component: DtUserProfile,
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
      component: DtUserStatus,
      dataAccessors: {
        email_verified_at: 'email_verified_at',
      },

    },
    {
      title: 'Registered',
      key: 'created_at',
      component: DtDate,
      options: {
        type: 'Date.Formatted',
      },
    },
  ]

  actions: DataTableActionsOptions = {
    enabled: true,
    baseUrl: '/users',
    destroyDialog: DeleteUser,
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
