<template>
  <button
      :type="type"
      class="inline-flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold
      text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:outline-none focus:border-red-700 focus:ring
      focus:ring-red-400 active:bg-red-600 transition ease-in-out duration-150 dark:bg-red-800 dark:hover:bg-red-700
      dark:focus:ring-red-500 dark:text-zinc-100"
  >
    <slot/>
  </button>
</template>

<script lang="ts">
import { Vue, Component, Prop } from 'vue-property-decorator'

@Component
export default class DangerButton extends Vue {
  @Prop({
    default: 'button',
    type: String,
  }) readonly type!: string
}
</script>
