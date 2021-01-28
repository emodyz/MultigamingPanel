<template>
  <button
      @click="handleClick"
      :disabled="disabled"
      type="button"
      class="ml-auto
      disabled:cursor-not-allowed disabled:opacity-75 inline-flex items-center px-4 py-2 bg-gray-800 border
      border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-gray-700
      active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-400 transition ease-in-out
      duration-150 text-base"
  >
    Write a new article<DocumentAdd class="ml-2 h-6 w-6" />
  </button>
</template>

<script lang="ts">
import { Component, Mixins } from 'vue-property-decorator'
import DocumentAdd from '@/Shared/Svgs/DocumentAdd.vue'
import Route from '@/Mixins/Route'

@Component({
  components: {
    DocumentAdd,
  },
})
export default class CreateArticleButton extends Mixins(Route) {
  disabled = false

  handleClick() {
    this.$inertia.visit(this.route('articles.create'))
  }
}
</script>
