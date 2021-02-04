<template>
  <article class="prose dark:prose-light" v-html="content"/>
</template>

<script lang="ts">
import {
  Vue, Component, Prop, Watch,
} from 'vue-property-decorator'

@Component
export default class ArticlePreview extends Vue {
  @Prop({
    type: String,
    default: null,
    required: true,
  }) content !: string

  @Watch('content')
  onCc(newVal: any) {
    console.log(newVal)
  }
}
</script>
