<template>
  <div class="text-gray-300">
    <span :key="item.id" v-for="(item, index) in array">
      <span v-if="index > 0">, </span>
      <inertia-link preserve-scroll class="link-brand" :href="route('modpacks.update.show', item.id)">{{ item.name }}</inertia-link>
    </span>
  </div>
</template>

<script lang="ts">
import { Component, Mixins, Prop } from 'vue-property-decorator'
import Helpers from '@/Mixins/Helpers'
import Route from '@/Mixins/Route'

@Component
export default class DataTable_ServerModPacks extends Mixins(Helpers, Route) {
  @Prop({ required: false, default: () => ({ separator: ', ', itemKey: 'name' }) }) readonly options!: any

  @Prop({ required: true }) readonly data!: any

  @Prop({ required: true }) readonly dataAccessors!: any

  array: Array<any> = this.getWithDataAccessors(this.data, this.dataAccessors.array)

  printable: string = ''

  initPrintable() {
    this.array.forEach((val: any) => {
      if (this.printable.length === 0) {
        this.printable = val[this.options.itemKey]
        return
      }
      this.printable = this.printable.concat(this.options.separator, val[this.options.itemKey])
    })
  }

  created() {
    // console.log(this.array)
  }
}
</script>
