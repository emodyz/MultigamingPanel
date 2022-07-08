<template>
  <div class="dark:text-zinc-300">
    <span v-if="options.type === 'Date.Formatted'">
      {{
        $moment(date)
            .format('LLL')
      }}
    </span>
    <span v-else-if="options.type === 'Date.FromNow'">
        <span v-if="date === null">Never</span>
        <span v-else>{{
            $moment(date)
                .fromNow()
          }}</span>
    </span>
  </div>
</template>

<script lang="ts">
import { Component, Prop, Mixins } from 'vue-property-decorator'
import Helpers from '@/Mixins/Helpers'

@Component
export default class DataTable_Date extends Mixins(Helpers) {
  @Prop({ required: true }) readonly options!: any

  @Prop({ required: true }) readonly itemKey!: any

  @Prop({ required: true }) readonly data!: any

  date = this.getWithDataAccessors(this.data, this.itemKey)
}
</script>
