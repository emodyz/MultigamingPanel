<template>
  <button
    :disabled="disabled"
    :type="type"
    class="disabled:cursor-not-allowed disabled:opacity-75 inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-indigo-300 focus:ring focus:ring-indigo-400 active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150"
  >
    <slot />
  </button>
</template>

<script lang="ts">
import { Vue, Component, Prop } from 'vue-property-decorator'

@Component
export default class SecondaryButton extends Vue {
    @Prop({ default: 'button', type: String }) readonly type!: string

    @Prop({ default: false, type: Boolean }) readonly disabled!: boolean
}
</script>
