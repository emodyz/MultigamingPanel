<template>
  <div>
    <span class="dark:text-gray-300">
      {{ printable }}
    </span>
  </div>
</template>

<script lang="ts">
import { Component, Prop, Mixins } from 'vue-property-decorator'
import Helpers from '@/Mixins/Helpers'

@Component
// eslint-disable-next-line camelcase
export default class DataTable_DefaultRow extends Mixins(Helpers) {
  @Prop({ required: true }) readonly data!: string | null

  @Prop({ required: true }) readonly itemKey!: any

  printable = this.getWithDataAccessors(this.data, this.itemKey)
}
</script>
