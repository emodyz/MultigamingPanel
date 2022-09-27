<template>
  <div>
    <div v-if="status.online" class="relative inline-flex rounded-full shadow-sm">
      <span class="inline-flex items-center px-2 text-xs leading-5 font-semibold rounded-full
        bg-green-100 text-green-800 dark:text-emerald-300 dark:bg-emerald-900">
        {{ status.players_online }} / {{ status.players_max }} Players
      </span>
      <span class="flex absolute h-3 w-3 top-0 right-0 -mt-1 -mr-1">
        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 dark:bg-emerald-500 opacity-75"></span>
        <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500 dark:bg-emerald-300"></span>
      </span>
    </div>
    <div v-else class="relative inline-flex rounded-full shadow-sm">
      <span class="inline-flex items-center px-2 inline-flex text-xs leading-5 font-semibold rounded-full
        bg-red-500 text-white dark:bg-red-900 dark:text-zinc-300">
        Offline
      </span>
    </div>
  </div>
</template>

<script lang="ts">
import { Component, Prop, Mixins } from 'vue-property-decorator'
import Helpers from '@/Mixins/Helpers'

@Component
export default class DataTable_ServerStatus extends Mixins(Helpers) {
  @Prop({ required: true }) readonly data!: any

  @Prop({ required: true }) readonly dataAccessors!: any

  status: any = this.getWithDataAccessors(this.data, this.dataAccessors.status)
}
</script>
