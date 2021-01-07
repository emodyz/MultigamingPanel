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
                    <md-editor v-model="content"/>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script lang="ts">

import { Mixins, Component /* Watch */ } from 'vue-property-decorator'
import AppLayout from '@/Layouts/AppLayout.vue'
import Route from '@/Mixins/Route'
import JetInput from '@/Jetstream/Input.vue'
import JetInputArea from '@/Jetstream/InputArea.vue'
import JetInputError from '@/Jetstream/InputError.vue'
import JetLabel from '@/Jetstream/Label.vue'
import MdEditor from '@/Pages/News/Components/MdEditor.vue'

@Component({
  components: {
    AppLayout,
    JetInput,
    JetInputArea,
    JetInputError,
    JetLabel,
    MdEditor,
  },
})
export default class ArticlesCreate extends Mixins(Route) {
  content: string = ''
  /*
  @Watch('content', { immediate: true, deep: true })
  // eslint-disable-next-line no-unused-vars
  onContentChanged(val: string, oldVal: string) {
    console.log(this.test)
  } */

  created() {
    //
  }
}
</script>
