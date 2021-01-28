<template>
  <button
      @click="handleClick"
      :disabled="disabled"
      type="button"
      class="ml-auto
      disabled:cursor-not-allowed disabled:opacity-75 inline-flex items-center px-4 py-2 bg-gray-800 border
      border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-gray-700
      active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-400 transition ease-in-out
      duration-150"
  >
    Add a new server <Servers class="ml-2 h-4 w-4" />
  </button>
</template>

<script lang="ts">
import { Component, Mixins } from 'vue-property-decorator'
import Route from '@/Mixins/Route'
import Servers from '@/Shared/Svgs/Servers.vue'

@Component({
  components: {
    Servers,
  },
})
export default class CreateServerButton extends Mixins(Route) {
  disabled = false

  handleClick() {
    this.$inertia.visit(this.route('servers.create'))
  }
}
</script>
