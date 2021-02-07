<!-- TODO: Slide-in from the right animation -->

<template>
  <transition
      appear
      appear-class="scale-0"
      appear-to-class="scale-100"
      appear-active-class="origin-top-right transition transform-gpu duration-500 ease-in-out"
      enter-class="scale-0"
      enter-to-class="scale-100"
      enter-active-class="origin-top-right transition transform-gpu duration-500 ease-in-out"
      leave-class="scale-100"
      leave-to-class="scale-0"
      leave-active-class="origin-top-right transition transform-gpu duration-500 ease-in-out"
  >
    <div v-if="!dismissed"
         class="w-112 fixed top-5 right-5 z-40 shadow-lg border border-gray-100 p-4 flex rounded-lg bg-white
         dark:border-transparent dark:bg-gray-700">
      <div :class="[!doesNotExist(icon.component) ? 'pr-2': '' , icon.color]">
        <component :is="icon.component" />
      </div>
      <div class="w-104">
        <div>
          <span :class="!doesNotExist(icon.component) ? 'w-88': 'w-96'" class="text-md inline-block break-words dark:text-gray-100">
            {{ flash.title }}
          </span>
          <button @click="dismissed = true" type="button" aria-label="Close Notification"
                  class="ml-2 float-right hover:cursor-pointer rounded-full dark:text-gray-100 dark:focus:text-gray-300
                  focus:outline-none focus:text-gray-600">
            <cross-icon class="w-5 h-5"/>
          </button>
        </div>
        <div v-if="!doesNotExist(flash.message)" class="text-sm text-gray-600 dark:text-gray-300 tracking-tight pt-2">
          {{ flash.message }}
        </div>
      </div>
    </div>
  </transition>
</template>

<script lang="ts">
import {
  Component, Prop, Mixins, Watch,
} from 'vue-property-decorator'
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

  @Prop({ type: Number, default: 5000 }) timeout!: number;

  dismissed = false

  @Watch('flash')
  onFlashChanged(newFlash: any, oldFlash: any) {
    if (newFlash !== oldFlash) {
      this.dismissed = true

      this.icon = this.initNotificationIcon()

      setTimeout(() => {
        this.dismissed = false
      }, 500)
    }

    setTimeout(() => {
      this.dismissed = true
    }, this.timeout)
  }

  icon: any = this.initNotificationIcon()

  initNotificationIcon(): any {
    switch (this.flash.level) {
      case 'info':
        return { component: 'InfoCircleSolid', color: 'text-indigo-500 dark:text-indigo-400' }
      case 'success':
        return { component: 'CheckMarkSolid', color: 'text-green-500 dark:text-emerald-500' }
      case 'warning':
        return { component: 'WarningSignSolid', color: 'text-orange-500' }
      case 'danger':
        return { component: 'ErrorCircleSolid', color: 'text-red-500' }
      case 'error':
        return { component: 'ErrorCircleSolid', color: 'text-red-500' }
      default:
        return { component: null, color: null }
    }
  }

  created() {
    setTimeout(() => {
      this.dismissed = true
    }, this.timeout)
  }
}
</script>
