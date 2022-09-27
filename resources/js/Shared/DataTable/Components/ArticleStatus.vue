<template>
  <div>
    <span
        v-if="status === 'published'"
        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800
        dark:text-emerald-300 dark:bg-emerald-900"
    >
      Published | {{ $moment(published_at).fromNow() }}
    </span>
    <span
        v-else
        class="px-2 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full bg-zinc-100 text-zinc-800
        dark:bg-zinc-900 border dark:border-zinc-700 dark:text-zinc-300"
    >
      Draft
    </span>
  </div>
</template>

<script lang="ts">
import { Vue, Component, Prop } from 'vue-property-decorator'

@Component
export default class DataTable_ArticleStatus extends Vue {
  @Prop({ required: true }) readonly data!: any

  status: string = this.data.status

  published_at: any = this.data.published_at
}
</script>
