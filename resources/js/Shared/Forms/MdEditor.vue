<template>
  <div class="flex flex-col">
    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
      <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
        <div class="shadow overflow-hidden bg-gray-50 border border-gray-200 sm:rounded-lg divide-y divide-gray-200 sm:h-page">
          <div class="flex flex-row divide-x divide-gray-200 h-full">
            <div class="w-1/2 py-3 px-6">
              <textarea
                  maxlength="4294967294"
                  ref="input"
                  class="form-input rounded-md resize-none shadow-sm w-full h-full"
                  :value="value"
                  placeholder="Content..."
                  @input="handleInput($event.target.value)"
              />
            </div>
            <div class="w-prose py-3 px-6 overflow-y-scroll">
              <article-preview class="h-full" :content="parsedContent"></article-preview>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">

import {
  Mixins, Component, Watch, Prop, Ref,
} from 'vue-property-decorator'
import AppLayout from '@/Layouts/AppLayout.vue'
import Route from '@/Mixins/Route'
import JetInput from '@/Jetstream/Input.vue'
import JetInputArea from '@/Jetstream/InputArea.vue'
import JetInputError from '@/Jetstream/InputError.vue'
import JetLabel from '@/Jetstream/Label.vue'
import ArticlePreview from '@/Shared/Article/Preview.vue'
import marked from 'marked'

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
export default class MdEditor extends Mixins(Route) {
  @Prop({ default: 'i need my v-model' }) value!: any

  @Ref('input') readonly input!: HTMLInputElement

  parsedContent = ''

  handleInput(val: any) {
    this.parsedContent = marked(val)
    this.$emit('input', val)
  }

  @Watch('value', { immediate: true, deep: true })
  onValueChanged(val: string, oldVal: string) {
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
