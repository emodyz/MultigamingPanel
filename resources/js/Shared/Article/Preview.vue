<template>
  <article class="prose" v-html="content"/>
</template>

<script lang="ts">
import {
  Vue, Component, Prop,
} from 'vue-property-decorator'

@Component
export default class ArticlePreview extends Vue {
@Prop({ type: String, default: null, required: true }) content !: string
}
</script>
