<template>
  <jet-button @click="handleClick" :disabled="disabled" type="button" class="text-base ml-auto">
    Add a new server <Servers class="ml-2 h-6 w-6" />
  </jet-button>
</template>

<script lang="ts">
import { Component, Mixins } from 'vue-property-decorator'
import Route from '@/Mixins/Route'
import Servers from '@/Shared/Svgs/Servers.vue'
import JetButton from '@/Jetstream/Button.vue'

@Component({
  components: {
    Servers,
    JetButton,
  },
})
export default class CreateServerButton extends Mixins(Route) {
  disabled = false

  handleClick() {
    this.$inertia.visit(this.route('servers.create'))
  }
}
</script>
