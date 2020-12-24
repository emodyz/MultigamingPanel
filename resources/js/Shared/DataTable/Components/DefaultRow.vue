<template>
  <div>
    <span>
      {{ data }}
    </span>
  </div>
</template>

<script lang="ts">
import { Vue, Component, Prop } from 'vue-property-decorator'

@Component
// eslint-disable-next-line camelcase
export default class DataTable_DefaultRow extends Vue {
    @Prop({ required: true }) readonly data!: string | null
}
</script>
