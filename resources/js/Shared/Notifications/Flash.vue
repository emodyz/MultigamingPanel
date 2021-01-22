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
      <div :class="[!doseNotExist(icon.component) ? 'pr-2': '' , icon.color]">
        <component :is="icon.component" />
      </div>
      <div class="w-104">
        <div>
          <span :class="!doseNotExist(icon.component) ? 'w-88': 'w-96'" class="text-md inline-block break-words">
            {{ flash.title }}
          </span>
          <button @click="dismissed = true" type="button" aria-label="Close Notification"
                  class="ml-2 float-right hover:cursor-pointer rounded-full focus:outline-none focus:text-gray-600">
            <cross-icon class="w-5 h-5"/>
          </button>
        </div>
        <div v-if="!doseNotExist(flash.message)" class="text-sm text-gray-600 tracking-tight pt-2">
          {{ flash.message }}
        </div>
      </div>
    </div>
  </transition>
</template>

<script lang="ts">
import { Component, Prop, Mixins } from 'vue-property-decorator'
import CheckMarkSolid from '@/Shared/Svgs/CheckMarkSolid.vue'
import CrossIcon from '@/Shared/Svgs/CrossIcon.vue'
import ErrorCircleSolid from '@/Shared/Svgs/ErrorCircleSolid.vue'
import InfoCircleSolid from '@/Shared/Svgs/InfoCircleSolid.vue'
import WarningSignSolid from '@/Shared/Svgs/WarningSignSolid.vue'
import Helpers from '@/Mixins/Helpers'

@Component({
  components: {
    CrossIcon,
    CheckMarkSolid,
    ErrorCircleSolid,
    InfoCircleSolid,
    WarningSignSolid,
  },
})
export default class FlashNotification extends Mixins(Helpers) {
  @Prop({ required: true }) flash!: any

  dismissed = false

  icon: any = this.initNotificationIcon()

  initNotificationIcon(): any {
    switch (this.flash.level) {
      case 'info':
        return { component: 'InfoCircleSolid', color: 'text-blue-500' }
      case 'success':
        return { component: 'CheckMarkSolid', color: 'text-green-500' }
      case 'warning':
        return { component: 'WarningSignSolid', color: 'text-orange-500' }
      case 'error' || 'danger':
        return { component: 'ErrorCircleSolid', color: 'text-red-500' }
      default:
        return { component: null, color: null }
    }
  }

  created() {
    console.log(this.flash)
  }
}
</script>
