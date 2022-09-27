<template>
  <div class="md:grid md:grid-cols-3 md:gap-6">
    <jet-section-title>
      <template #title>
        <slot name="title"/>
      </template>
      <template #description>
        <slot name="description"/>
      </template>
    </jet-section-title>

    <div class="mt-5 md:mt-0 md:col-span-2">
      <div class="px-4 py-5 sm:p-6 bg-white dark:bg-zinc-800 shadow sm:rounded-lg">
        <slot name="content"/>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { Vue, Component } from 'vue-property-decorator'

import JetSectionTitle from './SectionTitle.vue'

@Component({
  components: {
    JetSectionTitle,
  },
})
export default class ActionSection extends Vue {
  //
}
</script>
