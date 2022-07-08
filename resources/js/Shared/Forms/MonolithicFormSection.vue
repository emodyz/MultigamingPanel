<template>
  <form class="md:grid md:grid-cols-3 md:gap-6" @submit.prevent="$emit('submitted')">
    <jet-section-title>
      <template #title>
        <slot name="title"/>
      </template>
      <template #description>
        <slot name="description"/>
      </template>
    </jet-section-title>

    <div class="mt-5 md:mt-0 md:col-span-2">
      <div class="shadow overflow-hidden sm:rounded-md">
        <div class="px-4 py-5 bg-white dark:bg-zinc-800 sm:p-6">
          <div class="grid grid-cols-6 gap-6">
            <slot name="form"/>
          </div>
        </div>
      </div>
    </div>

    <div class="mt-5 md:mt-0 md:col-span-3">
      <slot name="customInputs"></slot>
    </div>

    <div class="mt-5 md:mt-0 md:col-span-3">
      <div class="shadow overflow-hidden sm:rounded-md">
        <div class="grid grid-cols-6 gap-6">
          <div
              v-if="hasActions"
              class="col-span-6 flex items-center justify-end px-4 py-3 bg-zinc-50 dark:bg-zinc-700 text-right sm:px-6"
          >
            <slot name="actions"/>
          </div>
        </div>
      </div>
    </div>
  </form>
</template>

<script lang="ts">
import {
  Vue, Component,
} from 'vue-property-decorator'
import JetSectionTitle from '@/Jetstream/SectionTitle.vue'

/**
 *  TODO: Create a custom stackable form section
 */
@Component({
  components: {
    JetSectionTitle,
  },
})
export default class MonolithicFormSection extends Vue {
  get hasActions() {
    return !!this.$slots.actions
  }
}
</script>
