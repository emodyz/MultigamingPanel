<template>
    <app-layout>
        <template #header>
            <h2 class="breadcrumb">
                ModPacks <span class="breadcrumb-separator">/</span> Edit <span class="breadcrumb-separator">/</span>
                {{ modpack.name }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <EditModPackForm :modpack="modpack" :servers="servers"/>
            </div>
        </div>
    </app-layout>
</template>

<script lang="ts">
import AppLayout from '@/Layouts/AppLayout.vue'

import { Component, Prop, Mixins } from 'vue-property-decorator'
import Route from '@/Mixins/Route'
import EditModPackForm from '@/Pages/ModPacks/Components/EditModPackForm.vue'

@Component({
  components: {
    EditModPackForm,
    AppLayout,
  },
})
export default class Modpacks_Edit extends Mixins(Route) {
  @Prop() readonly modpack!: any

  @Prop() readonly servers !: Array<any>
}
</script>

<style scoped>
</style>
