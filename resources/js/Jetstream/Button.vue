<template>
    <button :disabled="disabled" :type="type" class="disabled:cursor-not-allowed disabled:opacity-75 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-400 transition ease-in-out duration-150">
        <slot></slot>
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
