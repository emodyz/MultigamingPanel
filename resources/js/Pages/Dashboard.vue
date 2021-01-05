<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg h-screen">
                    <multi-select :options-prop="opts"/>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script lang="ts">
import {
  Vue, Component,
} from 'vue-property-decorator'

import AppLayout from '@/Layouts/AppLayout.vue'
import Welcome from '@/Jetstream/Welcome.vue'
import MultiSelect from '@/Shared/Forms/MultiSelect.vue'

@Component({
  components: {
    AppLayout,
    Welcome,
    MultiSelect,
  },
})
export default class Dashboard extends Vue {
  opts = [
    {
      name: 'Javascript',
      value: 'js',
    },
    {
      name: 'Ruby',
      value: 'rb',
    },
    {
      name: 'Python',
      value: 'py',
    },
    {
      name: 'PhP',
      value: 'php',
    },
    {
      name: 'C++',
      value: 'cpp',
    },
    {
      name: 'Java',
      value: 'java',
    },
  ]

  mounted() {
    // console.log('mounted')
  }
}
</script>
