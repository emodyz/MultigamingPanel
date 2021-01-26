<template>
  <div>
    <span>
      {{ printable }}
    </span>
  </div>
</template>

<script lang="ts">
import { Component, Mixins, Prop } from 'vue-property-decorator'
import Helpers from '@/Mixins/Helpers'

@Component
export default class DataTable_ConcatenatedStrings extends Mixins(Helpers) {
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
    this.initPrintable()
  }
}
</script>
