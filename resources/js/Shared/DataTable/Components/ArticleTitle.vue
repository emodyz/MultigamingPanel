<template>
  <div>
    <h1 class="font-bold text-lg text-zinc-700 dark:text-zinc-100">
      {{ title }}
    </h1>
    <div v-if="subTitle">
      <h3 class="font-semibold dark:text-zinc-400">
        {{ subTitle.trunc(80) }}
      </h3>
    </div>
  </div>
</template>

<script lang="ts">
import { Vue, Component, Prop } from 'vue-property-decorator'

@Component
export default class DataTable_ArticleTitle extends Vue {
  @Prop({ required: true }) readonly data!: any

  title: string = this.data.title

  subTitle: string = this.data.subTitle
}
</script>
