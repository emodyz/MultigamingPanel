<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Articles <span class="text-gray-400">/</span> Create
      </h2>
    </template>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <create-article-form :servers="servers"/>
      </div>
    </div>
  </app-layout>
</template>

<script lang="ts">

import { Vue, Component, Prop } from 'vue-property-decorator'
import AppLayout from '@/Layouts/AppLayout.vue'
import CreateArticleForm from '@/Pages/News/Components/CreateArticleForm.vue'

@Component({
  components: {
    AppLayout,
    CreateArticleForm,
  },
})
export default class ArticlesCreate extends Vue {
  @Prop() readonly servers !: Array<any>

  created() {
    // console.log(this.servers)
  }
}
</script>
