<template>
  <jet-button @click="handleClick" :disabled="disabled" type="button" class="text-base ml-auto">
    Write a new article <DocumentAdd class="ml-2 h-6 w-6" />
  </jet-button>
</template>

<script lang="ts">
import { Component, Mixins } from 'vue-property-decorator'
import DocumentAdd from '@/Shared/Svgs/DocumentAdd.vue'
import Route from '@/Mixins/Route'
import JetButton from '@/Jetstream/Button.vue'

@Component({
  components: {
    DocumentAdd,
    JetButton,
  },
})
export default class CreateArticleButton extends Mixins(Route) {
  disabled = false

  handleClick() {
    this.$inertia.visit(this.route('articles.create'))
  }
}
</script>
