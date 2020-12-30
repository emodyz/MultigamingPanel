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
              <div class="shadow-md bg-gray-50 border border-gray-200 sm:rounded-lg divide-y divide-gray-200">
                <jet-input
                    v-model="title"
                    class="w-1/3 my-3 mx-6 border-gray-200"
                    type="text"
                    placeholder="Title..."
                />
                <jet-input
                    v-model="subTitle"
                    class="w-1/3 my-3 mx-6 border-gray-200"
                    type="text"
                    placeholder="Sub Title..."
                />
                <div class="flex flex-row divide-x divide-gray-200">
                  <div class="w-1/2 py-3 px-6">
                    <jet-input-area
                        v-model="content"
                        class="w-full h-full overflow-y-scroll border-gray-200"
                        placeholder="Content..."
                    ></jet-input-area>
                  </div>
                  <div class="w-1/2">
                    <article-preview class="py-3 px-6" :content="content"></article-preview>
                  </div>
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

import { Mixins, Component } from 'vue-property-decorator'
import AppLayout from '@/Layouts/AppLayout.vue'
import Route from '@/Mixins/Route'
import JetInput from '@/Jetstream/Input.vue'
import JetInputArea from '@/Jetstream/InputArea.vue'
import JetInputError from '@/Jetstream/InputError.vue'
import JetLabel from '@/Jetstream/Label.vue'
import ArticlePreview from '@/Shared/Article/Preview.vue'

@Component({
  components: {
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

  content = ''

  created() {
    //
  }
}
</script>
