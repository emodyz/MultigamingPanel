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
        ? 'block pl-3 pr-4 py-2 border-l-4 border-indigo-400 text-base font-medium text-indigo-700 dark:text-gray-100 bg-indigo-50 dark:bg-gray-900 focus:outline-none focus:text-indigo-800 focus:bg-indigo-100 focus:border-indigo-700 dark:focus:text-indigo-400 dark:focus:border-indigo-500 transition duration-150 ease-in-out'
        : 'block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 dark:text-gray-300 '
        + 'hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 dark:hover:text-gray-100 dark:hover:bg-gray-800 '
        + 'focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 dark:focus:text-gray-100 dark:focus:border-indigo-400 dark:focus:bg-gray-800 '
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
