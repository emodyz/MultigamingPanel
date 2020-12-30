<template>
  <article class="prose" v-html="parsedContent"/>
</template>

<script lang="ts">
import marked from 'marked'
import {
  Vue, Component,
} from 'vue-property-decorator'

@Component({
  props: {
    content: {
      type: String,
      default: null,
      required: true,
    },
  },
  computed: {
    parsedContent() {
      // @ts-ignore
      return marked(this.content)
    },
  },
})
export default class ArticlePreview extends Vue {
//
}
</script>
