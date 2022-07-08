<template>

  <div @click="handleSwitch"
       class="w-10 sm:w-14 md:w-10 h-6 flex items-center bg-zinc-300 rounded-full p-1 duration-300 ease-in-out"
       :class="{ 'bg-green-400 dark:bg-indigo-400': isActive}">
    <div class="bg-white w-4 h-4 rounded-full shadow-md transform duration-300 ease-in-out hover:cursor-pointer"
         :class="{ 'translate-x-4': isActive}">
          <moon class="text-indigo-400" v-if="isActive" />
          <sun  class="text-yellow-400" v-else/>
    </div>
  </div>
</template>

<script lang="ts">
import {
  Vue, Component, Prop,
} from 'vue-property-decorator'
import Moon from '@/Shared/Svgs/Moon.vue'
import Sun from '@/Shared/Svgs/Sun.vue'

@Component({
  components: {
    Moon,
    Sun,
  },
})
export default class ThemeSwitch extends Vue {
  @Prop({ default: false }) readonly value!: string | number | boolean | null

  isActive = this.value

  handleSwitch() {
    this.isActive = !this.isActive
    this.$emit('input', this.isActive)
  }
}
</script>
