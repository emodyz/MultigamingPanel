<template>
  <div class="md:grid md:grid-cols-3 md:gap-6 z-0">
    <slot name="label"/>
    <div class="mt-5 md:mt-0 md:col-span-2">
      <div class="overflow-y-visible sm:rounded-md shadow">
        <div class="px-4 py-5 bg-white dark:bg-gray-800 sm:rounded-md sm:p-6">
          <div class="grid grid-cols-6 gap-6">
            <slot name="input"/>
          </div>
        </div>
      </div>
    </div>
  </div>
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
