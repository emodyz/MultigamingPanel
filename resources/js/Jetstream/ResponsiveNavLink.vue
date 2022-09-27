<template>
  <div>
    <button
        v-if="as == 'button'"
        :class="classes"
        class="w-full text-left"
    >
      <slot/>
    </button>

    <Link
        v-else
        :href="href"
        :class="classes"
    >
      <slot/>
    </Link>
  </div>
</template>

<script lang="ts">
import { Vue, Component } from 'vue-property-decorator'
import { Link } from '@inertiajs/inertia-vue'

// TODO: Refactor 'classes' using @Watch

const respNavLink = Vue.extend({
  props: ['active', 'href', 'as'],
  computed: {
    classes() {
      return this.active
        ? 'block pl-3 pr-4 py-2 border-l-4 border-indigo-400 text-base font-medium text-indigo-700 dark:text-zinc-100 bg-indigo-50 dark:bg-zinc-900 focus:outline-none focus:text-indigo-800 focus:bg-indigo-100 focus:border-indigo-700 dark:focus:text-indigo-400 dark:focus:border-indigo-500 transition duration-150 ease-in-out'
        : 'block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-zinc-600 dark:text-zinc-300 '
        + 'hover:text-zinc-800 hover:bg-zinc-50 hover:border-zinc-300 dark:hover:text-zinc-100 dark:hover:bg-zinc-800 '
        + 'focus:outline-none focus:text-zinc-800 focus:bg-zinc-50 focus:border-zinc-300 dark:focus:text-zinc-100 dark:focus:border-indigo-400 dark:focus:bg-zinc-800 '
        + 'transition duration-150 ease-in-out'
    },
  },
})

@Component({
  components: {
    Link,
  },
})
export default class ResponsiveNavLink extends respNavLink {
  //
}
</script>
