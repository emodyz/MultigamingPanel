<template>
    <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
        <div class="flex-1 flex justify-between sm:hidden">
            <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:text-gray-500">
                Previous
            </a>
            <a href="#" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:text-gray-500">
                Next
            </a>
        </div>
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-700">
                    Showing
                    <span class="font-medium">{{ (pageNumber > 1) ? (pageNumber*10) - 10 + 1 : 1 }}</span>
                    to
                    <span class="font-medium">{{ (pageNumber > 1) ? (((pageNumber*10) > totalItemCount ? totalItemCount : (pageNumber*10))) : (10 > totalItemCount ? totalItemCount : 10) }}</span>
                    of
                    <span class="font-medium">{{ totalItemCount }}</span>
                    results
                </p>
            </div>
            <div>
                <nav class="relative z-0 inline-flex shadow-sm -space-x-px" aria-label="Pagination">
                    <template v-for="(link, key) in links">
                        <Inertia-link preserve-scroll :only="[queryParam, 'page', 'totalItemCount']" v-if="link.label === 'Previous'" :href="link.url ? link.url : '#'" :key="key" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                            <span class="sr-only">Previous</span>
                            <!-- Heroicon name: chevron-left -->
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </Inertia-link>

                        <Inertia-link preserve-scroll :only="[queryParam, 'page', 'totalItemCount']" v-else-if="link.label === 'Next'" :href="link.url ? link.url : '#'" :key="key" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                            <span class="sr-only">Next</span>
                            <!-- Heroicon name: chevron-right -->
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </Inertia-link>

                        <span v-else-if="link.label === '...'" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">
                          ...
                        </span>

                        <Inertia-link v-else preserve-scroll :only="[queryParam, 'page', 'totalItemCount']" :href="link.url" :key="key" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                            {{ link.label }}
                        </Inertia-link>
                    </template>
                </nav>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
    import {Vue, Component, Prop} from 'vue-property-decorator'
    import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue";
    import JetButton from "@/Jetstream/Button.vue";
    import qs from 'qs';

    //TODO: Fix pagination on sm screen size

    @Component({
        components: {
            JetSecondaryButton,
            JetButton
        }
    })
    export default class Pagination extends Vue {
        @Prop({ type: Array, required: true }) readonly links!: Array<any>
        @Prop({ type: Number, required: true }) readonly totalItemCount!: number
        @Prop({ type: String, required: true }) readonly queryParam: string

        query = qs.parse(window.location.search.slice(1))

        pageNumber = this.query.page ? this.query.page : 1

        created() {
            // console.log(this.links)
        }
    }
</script>
