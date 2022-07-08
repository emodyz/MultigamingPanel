<template>
  <button
    @click="$emit('click', $event)"
    :disabled="disabled"
    :type="type"
    class="disabled:cursor-not-allowed disabled:opacity-75 inline-flex items-center px-4 py-2 bg-zinc-800 border
    border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-zinc-700 active:bg-zinc-900
    focus:outline-none focus:border-zinc-900 focus:ring focus:ring-zinc-400 transition ease-in-out duration-150
    dark:text-zinc-100 dark:bg-indigo-500 dark:hover:bg-indigo-400 dark:active:bg-indigo-500 dark:focus:border-indigo-400
    dark:focus:ring-indigo-400 dark:disabled:bg-zinc-700"
  >
    <slot />
  </button>
</template>

<script lang="ts">
import { Vue, Component, Prop } from 'vue-property-decorator'

@Component
export default class Button extends Vue {
    @Prop({ default: 'submit', type: String }) readonly type!: string

    @Prop({ default: false, type: Boolean }) readonly disabled!: boolean
}
</script>
