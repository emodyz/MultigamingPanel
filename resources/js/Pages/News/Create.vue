<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Articles <span class="text-gray-400">/</span> Create
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex flex-col">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="shadow-md bg-gray-50 border border-gray-200 sm:rounded-lg divide-y divide-gray-200 sm:h-page">
                                <div class="flex flex-row divide-x divide-gray-200 h-full">
                                    <div class="w-1/2 py-3 px-6">
                                        <jet-input-area
                                                v-model="content"
                                                class="w-full h-full overflow-y-scroll border-gray-200"
                                                placeholder="Content..."
                                        ></jet-input-area>
                                    </div>
                                    <div class="w-prose py-3 px-6 overflow-y-scroll">
                                        <article-preview class="h-full" :content="parsedContent"></article-preview>
                                    </div>
                                    <button @click="log()">Log</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script lang="ts">

import { Mixins, Component, Watch } from 'vue-property-decorator'
import AppLayout from '@/Layouts/AppLayout.vue'
import Route from '@/Mixins/Route'
import JetInput from '@/Jetstream/Input.vue'
import JetInputArea from '@/Jetstream/InputArea.vue'
import JetInputError from '@/Jetstream/InputError.vue'
import JetLabel from '@/Jetstream/Label.vue'
import ArticlePreview from '@/Shared/Article/Preview.vue'
import Button from '@/Jetstream/Button.vue'
import marked from 'marked'

@Component({
  components: {
    Button,
    AppLayout,
    JetInput,
    JetInputArea,
    JetInputError,
    JetLabel,
    ArticlePreview,
  },
})
export default class ArticlesCreate extends Mixins(Route) {
  title = ''

  subTitle = ''

  content = ''

  parsedContent = ''

  @Watch('content', { immediate: true, deep: true })
  onContentChanged(val: string, oldVal: string) {
    if (val !== oldVal) {
      this.parsedContent = marked(val)
    }
  }

  log() {
    console.log(this.parsedContent)
  }

  created() {
    //
  }
}
</script>
