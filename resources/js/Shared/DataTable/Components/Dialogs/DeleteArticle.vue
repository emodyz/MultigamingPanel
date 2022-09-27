<template>
  <div>
    <span class="text-md">Are you sure you would like to delete this article ?</span>

    <div class="w-full flex flex-wrap space-x-4 items-start">
      <div class="flex flex-col mt-4 justify-center items-center w-full sm:w-7/12 h-auto">
        <div class="bg-zinc-300 dark:bg-zinc-900 h-56 w-full rounded-lg shadow-md bg-cover bg-center"
             :style="`background-image: url('${ data.cover_image_url }')`"></div>

        <div class="block prose dark:prose-light w-10/12 sm:w-72 dark:bg-zinc-700 dar -mt-10 shadow-lg rounded-lg overflow-hidden p-5">
          <h3>{{ data.title }}</h3>

          <div class="text-base text-justify dark:text-zinc-300">
            {{ data.subTitle }}
          </div>

          <span class="float-right mt-4 text-sm text-zinc-400 font-semibold text-right">
              Created {{
              $moment(data.created_at)
                  .fromNow()
            }}
          </span>
        </div>
      </div>

      <div class="hidden sm:block rounded-lg shadow-md mt-4 bg-zinc-50 dark:bg-zinc-700 px-4 py-5 flex-1">
        <div class="w-full mb-5">
          <h3 class="text-lg leading-6 font-medium text-zinc-900 dark:text-zinc-100">
            Attached servers
          </h3>
        </div>
        <dd class="mt-1 text-sm text-zinc-900 dark:text-zinc-100 sm:mt-0 sm:col-span-2">
          <ul class="border border-zinc-200 dark:border dark:border-zinc-600 rounded-md divide-y divide-zinc-200 dark:divide-zinc-600">
            <li v-if="data.servers.length === 0"
                class="pl-3 pr-4 py-3 flex items-center text-sm">
              <span class="truncate">
                No attached servers.
              </span>
            </li>
            <li v-else v-for="server of data.servers" :key="server.id+Math.random()"
                class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
              <div class="w-0 flex-1 flex items-center">
                <svg class="flex-shrink-0 h-5 w-5 text-zinc-400"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24"
                     xmlns="http://www.w3.org/2000/svg">
                  <path
                      d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"/>
                </svg>
                <span class="ml-2 flex-1 w-0 truncate">
                  {{ server.name }}
                </span>
              </div>
              <div class="ml-4 flex-shrink-0">
                <a class="font-medium link-brand" href="#">
                  See
                </a>
              </div>
            </li>
          </ul>
        </dd>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { Vue, Component, Prop } from 'vue-property-decorator'
import DtUserProfile from '@/Shared/DataTable/Components/UserProfile.vue'

@Component({
  components: {
    DtUserProfile,
  },
})
export default class DeleteArticle extends Vue {
  @Prop({
    type: Object,
    required: true,
  }) readonly data!: any
}
</script>
