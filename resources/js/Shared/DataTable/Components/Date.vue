<template>
  <div>
    <span v-if="type === 'Date.Formatted'">
      {{ $moment(date).format('LLL') }}
    </span>
    <span v-else-if="type === 'Date.FromNow'">
      {{ $moment(date).fromNow() }}
    </span>
  </div>
</template>

<script lang="ts">
import { Vue, Component, Prop } from 'vue-property-decorator'

@Component
// eslint-disable-next-line camelcase
export default class DataTable_Date extends Vue {
    @Prop({ type: String, required: true }) readonly type!: string

    @Prop({ type: String, required: true }) readonly date!: string
}
</script>
