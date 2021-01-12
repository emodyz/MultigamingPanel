<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Articles <span class="text-gray-400">/</span> Index
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <data-table
            :query-url="'/articles'"
            :query-param="'articles'"
            :headers="headers"
            :data-object="articles"
            data-type="Articles"
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
  @Prop() readonly articles!: null | object

  @Prop() readonly totalItemCount!: null | number

  @Prop() readonly initialSearch!: null | string

  headers: Array<DataTableHeader> = [
    {
      title: '#',
      key: 'index',
      type: 'Index',
    },
    {
      title: 'Title',
      key: 'title',
    },
    {
      title: 'Written By',
      key: 'author.name',
      type: 'User.Profile',
      dataAccessors: {
        name: 'author.name',
        email: 'author.email',
        profile_photo_url: 'author.profile_photo_url',
      },
    },
    {
      title: 'Written On',
      key: 'created_at',
      type: 'Date.Formatted',
    },
  ]

  actions: DataTableActionsOptions = {
    enabled: true,
    baseUrl: '/articles',
    actions: [
      {
        displayName: 'Edit',
        enabled: true,
        path: 'edit',
        permission: 'articles-edit',
        type: 'edit',
        class: 'text-indigo-600 hover:text-indigo-900',
      },
      {
        displayName: 'Delete',
        enabled: true,
        permission: 'articles-destroy',
        type: 'destroy',
        class: 'text-red-600 hover:text-red-900',
      },
    ],
  }

  created() {
    console.log(this.articles)
  }
}
</script>
