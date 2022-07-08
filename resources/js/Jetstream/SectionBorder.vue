<template>
  <div class="hidden sm:block">
    <div :class="padding">
      <div class="border-t border-zinc-200 dark:border-zinc-700" />
    </div>
  </div>
</template>

<script lang="ts">
import { Vue, Component, Prop } from 'vue-property-decorator'

@Component
export default class SectionBorder extends Vue {
  @Prop({ default: 'py-8' }) readonly padding !: string
}
</script>
