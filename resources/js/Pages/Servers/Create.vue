<template>
  <app-layout>
    <template #header>
      <h2 class="breadcrumb">
        Servers <span class="breadcrumb-separator">/</span> Create
      </h2>
    </template>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <create-server-form :mod-packs="modPacks" :games="games"/>
      </div>
    </div>
  </app-layout>
</template>

<script lang="ts">

import { Vue, Component, Prop } from 'vue-property-decorator'
import AppLayout from '@/Layouts/AppLayout.vue'
import CreateServerForm from '@/Pages/Servers/Components/CreateServerForm.vue'

@Component({
  components: {
    AppLayout,
    CreateServerForm,
  },
})
export default class ServersCreate extends Vue {
  @Prop() readonly modPacks !: Array<any>

  @Prop() readonly games !: Array<any>

  created() {
    // console.log('ModPacks:', this.modPacks)
    // console.log('Games:', this.games)
  }
}
</script>
