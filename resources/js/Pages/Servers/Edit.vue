<template>
  <app-layout>
    <template #header>
      <h2 class="breadcrumb">
        Servers <span class="breadcrumb-separator">/</span> {{ server.name }} <span class="breadcrumb-separator">/</span> Edit
      </h2>
    </template>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <edit-server-form :server="server" :mod-packs="modPacks" :games="games"/>
      </div>
    </div>
  </app-layout>
</template>

<script lang="ts">

import { Vue, Component, Prop } from 'vue-property-decorator'
import AppLayout from '@/Layouts/AppLayout.vue'
import EditServerForm from '@/Pages/Servers/Components/EditServerForm.vue'

@Component({
  components: {
    AppLayout,
    EditServerForm,
  },
})
export default class ServersCreate extends Vue {
  @Prop() readonly server !: any

  @Prop() readonly modPacks !: Array<any>

  @Prop() readonly games !: Array<any>

  created() {
    // console.log('ModPacks:', this.modPacks)
    // console.log('Games:', this.games)
  }
}
</script>
