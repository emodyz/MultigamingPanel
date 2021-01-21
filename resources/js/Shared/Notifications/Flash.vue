<!-- TODO: Slide-in from the right animation -->
<template>
  <transition
      appear
      appear-class="scale-0"
      appear-to-class="scale-100"
      appear-active-class="origin-top-right transition transform-gpu duration-500 ease-in-out"
      leave-class="scale-100"
      leave-to-class="scale-0"
      leave-active-class="origin-top-right transition transform-gpu duration-500 ease-in-out"
  >
    <div v-if="!dismissed"
         class="w-112 absolute top-5 right-5 z-40 shadow-lg border border-gray-100 rounded-lg bg-white p-4 flex">
      <div class="pr-2 text-green-500">
        <check-mark-solid/>
      </div>
      <div>
        <div class="text-md pb-2">
          {{ flash.title }}
          <button @click="dismissed = true" type="button" aria-label="Close Notification"
                  class="ml-2 float-right hover:cursor-pointer rounded-full focus:outline-none focus:text-gray-600">
            <cross-icon/>
          </button>
        </div>
        <div class="text-sm text-gray-600  tracking-tight">
          {{ flash.message }}
        </div>
      </div>
    </div>
  </transition>
</template>

<script lang="ts">
import { Vue, Component, Prop } from 'vue-property-decorator'
import CheckMarkSolid from '@/Shared/Svgs/CheckMarkSolid.vue'
import CrossIcon from '@/Shared/Svgs/CrossIcon.vue'

@Component({
  components: { CrossIcon, CheckMarkSolid },
})
export default class FlashNotification extends Vue {
  @Prop({ required: true }) flash!: any

  dismissed = false

  created() {
    console.log(this.flash)
  }
}
</script>
