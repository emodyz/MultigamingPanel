<template>
  <input
      ref="input"
      class="form-input rounded-md shadow-sm"
      :value="value"
      @input="$emit('input', $event.target.value)"
  >
</template>

<script lang="ts">
import {
  Vue, Component, Prop, Ref,
} from 'vue-property-decorator'

@Component
export default class Input extends Vue {
  @Prop({ default: 'button' }) readonly value!: string | number | boolean |null

  @Ref('input') readonly input!: HTMLInputElement

  focus() {
    this.input.focus()
  }
}
</script>
