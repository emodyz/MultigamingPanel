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
                            :data-object="servers"
                            :headers="headers"
                            :initial-query="initialSearch"
                            :query-param="'servers'"
                            :query-url="'/servers'"
                            :total-item-count="totalItemCount"
                            class="w-full p-6">

                    <template #action>
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
// import DeleteModPack from '@/Shared/DataTable/Components/Dialogs/DeleteModPack.vue'
import DtBasicProfile from '@/Shared/DataTable/Components/BasicProfile.vue'
import DtDate from '@/Shared/DataTable/Components/Date.vue'
import DtServerModPacks from '@/Shared/DataTable/Components/ServerModPacks.vue'
import DtServerStatus from '@/Shared/DataTable/Components/ServerStatus.vue'

@Component({
  components: {
    DataTable,
    AppLayout,
    JetNavLink,
    JetDangerButton,
  },
})
export default class ServersIndex extends Mixins(Route) {
  @Prop() readonly servers!: null | object

  @Prop() readonly totalItemCount!: null | number

  @Prop() readonly initialSearch!: null | string

  created() {
    console.log(this.servers)
  }

  headers: Array<DataTableHeader> = [
    {
      title: '#',
      key: 'index',
      component: 'Index',
    },
    {
      title: 'Name',
      component: DtBasicProfile,
      key: 'name',
      dataAccessors: {
        name: 'name',
        logo_url: 'logo_url',
      },
    },
    {
      title: 'Game',
      component: DtBasicProfile,
      key: 'game_id',
      dataAccessors: {
        name: 'game.name',
        logo_url: 'game.logo_url',
      },
    },
    {
      title: 'ModPacks',
      component: DtServerModPacks,
      key: 'modpacks',
      order: false,
      dataAccessors: {
        array: 'modpacks',
      },
    },

    {
      title: 'Status',
      component: DtServerStatus,
      key: 'latest_status',
      order: false,
      dataAccessors: {
        status: 'latest_status',
      },
    },
    /*
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
      component: DtModPackSize,
      order: false,
    },
    {
      title: 'Files',
      key: 'manifest_info.files',
      component: DtModPackFiles,
      order: false,
    },
     */
    {
      title: 'Created',
      key: 'created_at',
      component: DtDate,
      options: {
        type: 'Date.Formatted',
      },
    },
  ]

  actions: DataTableActionsOptions = {
    enabled: true,
    baseUrl: '/servers',
    // destroyDialog: DeleteModPack,
    actions: [
      {
        displayName: 'Edit',
        enabled: true,
        permission: 'servers-edit',
        path: 'edit',
        type: 'edit',
        class: 'text-indigo-600 hover:text-indigo-900',
      },
      {
        displayName: 'Delete',
        enabled: true,
        permission: 'servers-destroy',
        type: 'destroy',
        class: 'text-red-600 hover:text-red-900',
      },
    ],
  }
}
</script>
