<template>
  <div class="md:col-span-1">
    <div class="px-4 sm:px-0">
      <h3 class="text-lg font-medium text-zinc-900 dark:text-zinc-100">
        <slot name="title"/>
      </h3>

      <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">
        <slot name="description"/>
      </p>
    </div>
  </div>
</template>

<script lang="ts">
import { Vue, Component } from 'vue-property-decorator'

@Component
export default class SectionTitle extends Vue {
  //
}
</script>
