<template>
  <label class="block font-medium text-sm text-gray-700 dark:text-gray-300 subpixel-antialiased">
    <span v-if="value">{{ value }}</span>
    <span v-else><slot/></span>
  </label>
</template>

<script lang="ts">
import {
  Vue, Component, Prop,
} from 'vue-property-decorator'

@Component
export default class Label extends Vue {
  @Prop() readonly value!: string | number
}
</script>
