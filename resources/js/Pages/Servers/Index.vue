<template>
    <app-layout>
        <template #header>
            <h2 class="breadcrumb">
                ModPacks <span class="breadcrumb-separator">/</span> Index
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-screen-2xl mx-auto sm:px-6 lg:px-8">
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
                      <create-server-button/>
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
import DtBasicProfile from '@/Shared/DataTable/Components/BasicProfile.vue'
import DtServerProfile from '@/Shared/DataTable/Components/ServerProfile.vue'
import DtDate from '@/Shared/DataTable/Components/Date.vue'
import DtServerModPacks from '@/Shared/DataTable/Components/ServerModPacks.vue'
import DtServerStatus from '@/Shared/DataTable/Components/ServerStatus.vue'
import CreateServerButton from '@/Pages/Servers/Components/CreateServerButton.vue'
import DeleteServer from '@/Shared/DataTable/Components/Dialogs/DeleteServer.vue'

@Component({
  components: {
    DataTable,
    AppLayout,
    JetNavLink,
    JetDangerButton,
    CreateServerButton,
  },
})
export default class ServersIndex extends Mixins(Route) {
  @Prop() readonly servers!: null | object

  @Prop() readonly totalItemCount!: null | number

  @Prop() readonly initialSearch!: null | string

  created() {
    // console.log(this.servers)
  }

  headers: Array<DataTableHeader> = [
    {
      title: '#',
      key: 'index',
      component: 'Index',
    },
    {
      title: 'Name',
      component: DtServerProfile,
      key: 'name',
      dataAccessors: {
        name: 'name',
        logo_url: 'logo_url',
        ip: 'ip',
        port: 'port',
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
    destroyDialog: DeleteServer,
    actions: [
      {
        displayName: 'Edit',
        enabled: true,
        permission: 'servers-edit',
        path: 'edit',
        type: 'edit',
        class: 'link-brand',
      },
      {
        displayName: 'Delete',
        enabled: true,
        permission: 'servers-destroy',
        type: 'destroy',
        class: 'link-danger',
      },
    ],
  }
}
</script>
