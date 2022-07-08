<template>
  <div class="bg-white dark:bg-zinc-700 px-4 py-3 flex items-center justify-between border-t border-zinc-200 dark:border-zinc-300 sm:px-6">
    <!-- Mobile -->
    <!-- <div class="flex-1 flex justify-between sm:hidden">
      <a
        href="#"
        class="relative inline-flex items-center px-4 py-2 border border-zinc-300 text-sm font-medium rounded-md text-zinc-700 bg-white hover:text-zinc-500"
      >
        Previous
      </a>
      <a
        href="#"
        class="ml-3 relative inline-flex items-center px-4 py-2 border border-zinc-300 text-sm font-medium rounded-md text-zinc-700 bg-white hover:text-zinc-500"
      >
        Next
      </a>
    </div>-->
  <!-- Tablets & desktop -->
  <div class="flex-1 flex items-center justify-between">
    <div>
      <p class="text-sm text-zinc-700 dark:text-zinc-300">
        Showing
        <span class="font-medium">{{ (pageNumber > 1) ? (pageNumber * 10) - 10 + 1 : 1 }}</span>
        to
        <span class="font-medium">{{
            (pageNumber > 1) ? (((pageNumber * 10) > totalItemCount ? totalItemCount : (pageNumber * 10))) : (10 > totalItemCount ? totalItemCount : 10)
          }}</span>
        of
        <span class="font-medium">{{ totalItemCount }}</span>
        results
      </p>
    </div>
    <div>
      <nav
          class="relative z-0 inline-flex shadow-sm -space-x-px"
          aria-label="Pagination"
      >
        <template v-for="(link, key) in links">
          <Link
              v-if="link.label === 'Previous'"
              :key="key"
              preserve-scroll
              :only="[queryParam, 'orderBy', 'page', 'totalItemCount', 'initialSearch']"
              :href="link.url ? link.url : '#'"
              class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-zinc-300 bg-white text-sm
              font-medium text-zinc-500 hover:bg-zinc-50 shadow-sm focus:outline-none focus:ring focus:ring-indigo-400
              dark:text-zinc-100 dark:bg-zinc-700 dark:border-zinc-600 dark:hover:bg-zinc-800"
          >
            <span class="sr-only">Previous</span>
            <!-- Heroicon name: chevron-left -->
            <svg
                class="h-5 w-5"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 20 20"
                fill="currentColor"
                aria-hidden="true"
            >
              <path
                  fill-rule="evenodd"
                  d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                  clip-rule="evenodd"
              />
            </svg>
          </Link>

          <Link
              v-else-if="link.label === 'Next'"
              :key="key"
              preserve-scroll
              :only="[queryParam, 'orderBy', 'page', 'totalItemCount', 'initialSearch']"
              :href="link.url ? link.url : '#'"
              class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-zinc-300 bg-white text-sm
              font-medium text-zinc-500 hover:bg-zinc-50 focus:outline-none focus:ring focus:ring-indigo-400
              dark:text-zinc-100 dark:bg-zinc-700 dark:border-zinc-600 dark:hover:bg-zinc-800"
          >
            <span class="sr-only">Next</span>
            <!-- Heroicon name: chevron-right -->
            <svg
                class="h-5 w-5"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 20 20"
                fill="currentColor"
                aria-hidden="true"
            >
              <path
                  fill-rule="evenodd"
                  d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                  clip-rule="evenodd"
              />
            </svg>
          </Link>

          <span
              :key="key"
              v-else-if="link.label === '...'"
              class="relative inline-flex items-center px-4 py-2 border border-zinc-300 bg-white text-sm font-medium text-zinc-700
              hover:bg-zinc-50 dark:text-zinc-100 dark:bg-zinc-700
              dark:border-zinc-600 dark:hover:bg-zinc-800"
          >
              ...
          </span>

          <Link
              v-else
              :key="key"
              preserve-scroll
              :only="[queryParam, 'orderBy', 'page', 'totalItemCount', 'initialSearch']"
              :href="link.url"
              class="relative inline-flex items-center px-4 py-2 border border-zinc-300 bg-white text-sm font-medium text-zinc-700
              hover:bg-zinc-50 focus:outline-none focus:ring focus:ring-indigo-400 dark:text-zinc-100 dark:bg-zinc-700
              dark:border-zinc-600 dark:hover:bg-zinc-800"
              :class="{'bg-zinc-100 dark:bg-zinc-800 dark:hover:bg-zinc-900': link.active}"
          >
            {{ link.label }}
          </Link>
        </template>
      </nav>
    </div>
  </div>
  </div>
</template>

<script lang="ts">
import { Vue, Component, Prop } from 'vue-property-decorator'
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'
import JetButton from '@/Jetstream/Button.vue'
import qs from 'qs'
import { Link } from '@inertiajs/inertia-vue'

// TODO: Fix pagination on sm screen size

@Component({
  components: {
    Link,
    JetSecondaryButton,
    JetButton,
  },
})
export default class Pagination extends Vue {
  @Prop({
    type: Array,
    required: true,
  }) readonly links!: Array<any>

  @Prop({
    type: Number,
    required: true,
  }) readonly totalItemCount!: number

  @Prop({
    type: String,
    required: true,
  }) readonly queryParam: string

  query = qs.parse(window.location.search.slice(1))

  pageNumber = this.query.page ? this.query.page : 1

  created() {
    // console.log(this.links)
  }
}
</script>
