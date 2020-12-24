<template>
  <div>
    <button
      v-if="as == 'button'"
      type="submit"
      class="text-left block w-full px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
    >
      <slot/>
    </button>

    <inertia-link
      v-else
      :href="href"
      class="text-left block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
    >
      <slot/>
    </inertia-link>
  </div>
</template>

<script lang="ts">

import { Vue, Component } from 'vue-property-decorator'

const dropLink = Vue.extend({
  props: ['href', 'as'],
})

@Component
export default class DropdownLink extends dropLink {
  //
}
</script>
