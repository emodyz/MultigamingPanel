<template>
  <div class="flex items-center">
    <div class="flex-shrink-0 h-10 w-10">
      <img
        class="h-10 w-10 rounded-lg"
        :src="logo_url"
        :alt="name"
      >
    </div>
    <div class="ml-4">
      <div class="text-sm font-semibold text-gray-900">
        {{ name }}
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { Component, Prop, Mixins } from 'vue-property-decorator'
import Helpers from '@/Mixins/Helpers'

@Component
export default class DataTable_BasicProfile extends Mixins(Helpers) {
  @Prop({ required: true }) readonly data!: any

  @Prop({ required: true }) readonly dataAccessors!: any

  name: string = this.getWithDataAccessors(this.data, this.dataAccessors.name)

  logo_url: string = this.getWithDataAccessors(this.data, this.dataAccessors.logo_url)
}
</script>
