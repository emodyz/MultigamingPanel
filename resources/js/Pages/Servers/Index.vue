<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                ModPacks <span class="text-gray-400">/</span> Index
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <data-table
                            :actions="actions"
                            :data-object="modpacks"
                            :headers="headers"
                            :initial-query="initialSearch"
                            :query-param="'modpacks'"
                            :query-url="'/modpacks'"
                            :total-item-count="totalItemCount"
                            class="w-full p-6"
                            data-type="ModPacks">

                    <template #action>
                        <CreateModPackModal
                                :servers="servers"
                                :games="games"
                        />
                    </template>

                </data-table>
            </div>
        </div>
    </app-layout>
</template>

<script lang="ts">
import AppLayout from '@/Layouts/AppLayout.vue'
import JetNavLink from '@/Jetstream/NavLink.vue'
import JetDangerButton from '@/Jetstream/DangerButton.vue'

import { Component, Prop, Mixins } from 'vue-property-decorator'
import Route from '@/Mixins/Route'
import DataTable from '@/Shared/DataTable/DataTable.vue'
import { DataTableHeader } from '@/Shared/DataTable/Types/DataTableHeader'
import { DataTableActionsOptions } from '@/Shared/DataTable/Types/DataTableActionsOptions'
import CreateModPackModal from '@/Pages/ModPacks/Components/CreateModPackModal.vue'

@Component({
  components: {
    CreateModPackModal,
    DataTable,
    AppLayout,
    JetNavLink,
    JetDangerButton,
  },
})
export default class ModPacks_Index extends Mixins(Route) {
  @Prop() readonly modpacks!: null | object

  @Prop() readonly servers!: null | object

  @Prop() readonly games!: null | object

  @Prop() readonly totalItemCount!: null | number

  @Prop() readonly initialSearch!: null | string

  processing: boolean = false

  form = {
    name: '',
    servers: [] as any,
  }

  headers: Array<DataTableHeader> = [
    {
      title: '###',
      key: 'index',
      type: 'Index',
    },
    {
      title: 'Game',
      type: 'Game.Profile',
      key: 'game',
      order: false,
      dataAccessors: {
        name: 'game.name',
        logo_url: 'game.logo_url',
      },
    },
    {
      title: 'Name',
      key: 'name',
    },
    {
      title: 'Path',
      key: 'path',
    },
    {
      title: 'Size',
      key: 'manifest_info.size',
      type: 'ModPack.Size',
      order: false,
    },
    {
      title: 'Files',
      key: 'manifest_info.files',
      type: 'ModPack.Files',
      order: false,
    },
    {
      title: 'Last Update',
      key: 'manifest_last_update',
      type: 'Date.FromNow',
    },
  ]

  actions: DataTableActionsOptions = {
    enabled: true,
    baseUrl: '/modpacks',
    actions: [
      {
        displayName: 'Update',
        enabled: true,
        permission: 'modpacks-update',
        path: 'update',
        type: 'custom',
        class: 'text-green-600 hover:text-green-900',
      },
      {
        displayName: 'Edit',
        enabled: true,
        permission: 'modpacks-edit',
        path: 'edit',
        type: 'edit',
        class: 'text-indigo-600 hover:text-indigo-900',
      },
      {
        displayName: 'Delete',
        enabled: true,
        permission: 'modpacks-destroy',
        type: 'destroy',
        class: 'text-red-600 hover:text-red-900',
      },
    ],
  }
}
</script>

<style scoped>

</style>
