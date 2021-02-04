<template>
  <article class="prose dark:prose-light" v-html="content"/>
</template>

<script lang="ts">
import {
  Vue, Component, Prop,
} from 'vue-property-decorator'

@Component
export default class ArticlePreview extends Vue {
  @Prop({ type: String, required: true }) content !: string
}
</script>
