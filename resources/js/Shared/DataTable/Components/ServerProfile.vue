<template>
  <div class="flex items-center">
    <div class="flex-shrink-0 h-10 w-10">
      <img
        class="h-10 w-10 rounded-full"
        :src="logo_url"
        :alt="`log of server ${name}`"
      >
    </div>
    <div class="ml-4">
      <div class="text-sm font-medium text-gray-900">
        {{ name }}
      </div>
      <div class="text-sm text-gray-500">
        {{ host }}
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { Component, Prop, Mixins } from 'vue-property-decorator'
import Helpers from '@/Mixins/Helpers'

@Component
export default class DataTable_ServerProfile extends Mixins(Helpers) {
  @Prop({ required: true }) readonly data!: any

  @Prop({ required: true }) readonly dataAccessors!: any

  name: string = this.getWithDataAccessors(this.data, this.dataAccessors.name)

  ip: string = this.getWithDataAccessors(this.data, this.dataAccessors.ip)

  port: string = this.getWithDataAccessors(this.data, this.dataAccessors.port)

  host: string = `${this.ip}:${this.port}`

  logo_url: string = this.getWithDataAccessors(this.data, this.dataAccessors.logo_url)
}
</script>
