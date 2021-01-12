<template>
  <div>
    <h1 class="font-bold text-lg text-gray-700">
      {{ title }}
    </h1>
    <div v-if="subTitle">
      <h3 class="font-semibold">
        {{ subTitle.trunc(80) }}
      </h3>
    </div>
  </div>
</template>

<script lang="ts">
import { Vue, Component, Prop } from 'vue-property-decorator'

@Component
// eslint-disable-next-line camelcase
export default class DataTable_ArticleTitle extends Vue {
  @Prop({ required: true }) readonly title!: string

  @Prop() readonly subTitle!: string | null
}
</script>
