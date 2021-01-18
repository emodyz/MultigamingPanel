<template>
  <transition
      appear
      appear-class="opacity-0 scale-0 origin-top-right"
      appear-to-class="opacity-100 scale-100"
      appear-active-class="transition-all duration-1000 ease-in-out"
  >
    <div v-show="!dismissed"
         class="absolute top-5 right-5 z-40 shadow-lg border border-gray-100 rounded-lg bg-white mx-auto p-4 notification-box flex max-w-md">
      <div class="pr-2 text-green-500">
        <svg class="fill-current h-6 w-6"
             xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd"
                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                clip-rule="evenodd"/>
        </svg>
      </div>
      <div>
        <div class="text-md pb-2">
          {{ flash.status.title }}
          <button @click="dismissed = true" type="button" aria-label="Close Notification"
                  class="ml-2 float-right hover:cursor-pointer rounded-full focus:outline-none focus:ring-2 focus:ring-indigo-600">
            <svg
                class="fill-current text-gray-600"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                width="22"
                height="22"
            >
              <path
                  class="heroicon-ui"
                  d="M16.24 14.83a1 1 0 0 1-1.41 1.41L12 13.41l-2.83 2.83a1 1 0 0 1-1.41-1.41L10.59 12 7.76 9.17a1 1 0 0 1 1.41-1.41L12 10.59l2.83-2.83a1 1 0 0 1 1.41 1.41L13.41 12l2.83 2.83z"
              />
            </svg>
          </button>
        </div>
        <div class="text-sm text-gray-600  tracking-tight ">
          {{ flash.status.message }}
        </div>
      </div>
    </div>
  </transition>
</template>

<script lang="ts">
import { Vue, Component, Prop } from 'vue-property-decorator'

@Component
export default class Notification extends Vue {
  @Prop({ required: true }) flash!: any

  dismissed = false

  created() {
    console.log(this.flash)
  }
}
</script>
