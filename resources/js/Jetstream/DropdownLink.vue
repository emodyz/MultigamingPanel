<template>
  <div>
    <button
      v-if="as == 'button'"
      type="submit"
      class="text-left block w-full px-4 py-2 text-sm leading-5 text-zinc-700 hover:bg-zinc-100 focus:outline-none
      focus:bg-zinc-100 transition duration-150 ease-in-out dark:text-zinc-300 dark:hover:bg-zinc-800 dark:focus:bg-zinc-900"
    >
      <slot/>
    </button>

    <Link
      v-else
      :href="href"
      class="text-left block px-4 py-2 text-sm leading-5 text-zinc-700 hover:bg-zinc-100 focus:outline-none focus:bg-zinc-100
      transition duration-150 ease-in-out dark:text-zinc-300 dark:hover:bg-zinc-800 dark:focus:bg-zinc-900"
    >
      <slot/>
    </Link>
  </div>
</template>

<script lang="ts">

import { Vue, Component } from 'vue-property-decorator'
import { Link } from '@inertiajs/inertia-vue'

const dropLink = Vue.extend({
  props: ['href', 'as'],
})

@Component({
  components: {
    Link,
  },
})
export default class DropdownLink extends dropLink {
  //
}
</script>
