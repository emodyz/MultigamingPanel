<template>
  <Link
    :href="href"
    :class="classes"
  >
    <slot/>
  </Link>
</template>

<script lang="ts">
import { Vue, Component } from 'vue-property-decorator'
import { Link } from '@inertiajs/inertia-vue'

// TODO: Refactor 'classes' using @Watch

const navLink = Vue.extend({
  props: ['href', 'active'],
  computed: {
    classes() {
      return this.active
        ? 'inline-flex items-center px-1 pt-1 border-b-2 border-indigo-400 text-sm font-medium leading-5 text-zinc-900 dark:text-zinc-100 dark:font-semibold dark:hover:border-indigo-500 focus:outline-none focus:border-indigo-500 transition duration-150 ease-in-out'
        : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-zinc-500 dark:text-zinc-300 hover:text-zinc-700 hover:border-zinc-300 dark:hover:border-zinc-400 dark:hover:text-zinc-100 focus:outline-none dark:focus:text-zinc-100 focus:border-zinc-300 transition duration-150 ease-in-out'
    },
  },
})

@Component({
  components: {
    Link,
  },
})
export default class NavLink extends navLink {
  //
}
</script>
