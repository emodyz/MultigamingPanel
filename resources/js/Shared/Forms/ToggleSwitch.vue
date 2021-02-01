<template>

  <div @click="handleSwitch"
       class="w-10 h-6 flex items-center bg-gray-300 rounded-full p-1 duration-300 ease-in-out"
       :class="{ 'bg-green-400 dark:bg-indigo-400': isActive}">
    <div class="bg-white w-4 h-4 rounded-full shadow-md transform duration-300 ease-in-out hover:cursor-pointer"
         :class="{ 'translate-x-4': isActive}"></div>
  </div>
</template>

<script lang="ts">
import {
  Vue, Component, Prop,
} from 'vue-property-decorator'

@Component
export default class ToggleSwitch extends Vue {
  @Prop({ default: false }) readonly value!: string | number | boolean | null

  isActive = this.value

  handleSwitch() {
    this.isActive = !this.isActive
    this.$emit('input', this.isActive)
  }
}
</script>
