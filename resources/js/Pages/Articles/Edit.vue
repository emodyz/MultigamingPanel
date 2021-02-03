<template>
  <app-layout>
    <template #header>
      <h2 class="breadcrumb">
        Articles <span class="breadcrumb-separator">/</span>
        Edit <span class="breadcrumb-separator">/</span>
        {{ article.title }} <span class="breadcrumb-separator">By</span>
        {{ article.author.name }}
      </h2>
    </template>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <edit-article-form :servers="servers" :article="article"/>
      </div>
    </div>
  </app-layout>
</template>

<script lang="ts">

import { Vue, Component, Prop } from 'vue-property-decorator'
import AppLayout from '@/Layouts/AppLayout.vue'
import EditArticleForm from '@/Pages/Articles/Components/EditArticleForm.vue'

@Component({
  components: {
    AppLayout,
    EditArticleForm,
  },
})
export default class ArticlesCreate extends Vue {
  @Prop() readonly servers !: Array<any>

  @Prop() readonly article !: Array<any>

  created() {
    // console.log(this.article)
  }
}
</script>
