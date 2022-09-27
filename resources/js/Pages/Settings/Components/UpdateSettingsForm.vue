<template>
  <div>
    <jet-form-section>
      <template #title>
        Update Settings (Alpha)
      </template>

      <template #description>
        Update your voice provider
      </template>

      <template #form>

        <!-- Name -->
        <div class="col-span-6 sm:col-span-4">
          <div class="inline-flex items-center text-zinc-700 dark:text-zinc-300">
            <spinner v-show="checkingVersion || isUpdating" class="h-7 w-7 mr-4 text-indigo-500"/>
            <check-mark-solid v-show="isUpToDate" class="h-7 w-7 mr-4 text-indigo-500"/>
            <info-circle-solid v-show="isUpdateAvailable" class="h-7 w-7 mr-4 text-green-500"/>
            <div class="flex flex-col items-start">
              <span v-show="checkingVersion">Checking for updates...</span>
              <span v-show="isUpToDate">EZGames is up to date</span>
              <span v-show="isUpdateAvailable">An update is available: <span class="text-green-500">{{newVersion}}</span></span>
              <div class="text-xs text-zinc-600 dark:text-zinc-400">
                Current version: <span class="text-zinc-700 dark:text-zinc-300">{{ currentVersion }}</span>
              </div>
            </div>
          </div>
          <div v-show="isUpdateAvailable" class="w-full">
            <jet-button @click="upgradeCp()" class="mt-6 ml-11 inline-flex items-center">
              <cloud-download class="mr-2"/> UPDATE
            </jet-button>
          </div>
        </div>
      </template>
    </jet-form-section>
    <div v-show="isUpdating" class="top-0 left-0 z-40 absolute block bg-zinc-900/75 dark:bg-zinc-900/50 backdrop-blur-sm w-full h-full flex justify-center items-center">
      <div v-show="!updateFailed" class="flex flex-col">
        <div class="text-zinc-100 inline-flex align-middle">
          <span class="mr-4 text-lg font-bold">Updating</span> <spinner class="w-7 h-7"/>
        </div>
        <span class="text-orange-400 text-sm font-semibold align-middle mt-4">Please, do NOT close or refresh this page. <br> This may take a few minutes.</span>
      </div>
      <div v-show="updateFailed" class="flex flex-col">
        <div class="text-zinc-100 inline-flex align-middle">
          <warning-sign-solid class="text-red-600 w-7 h-7 mr-4"/> <span class="text-lg font-bold select-none">Update Failed</span>
        </div>
        <div class="text-zinc-300 text-md font-semibold align-middle mt-4 select-none">
          <p>Please run <span class="font-bold p-2 bg-zinc-900 text-zinc-100 rounded select-text"><span class="select-none mr-2">$:</span>ezgames upgrade logs</span> for more information.</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import {
  Component, Mixins, Prop,
} from 'vue-property-decorator'
import JetFormSection from '@/Jetstream/FormSection.vue'
import JetLabel from '@/Jetstream/Label.vue'
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'
import JetInputError from '@/Jetstream/InputError.vue'
import JetInput from '@/Jetstream/Input.vue'
import JetActionMessage from '@/Jetstream/ActionMessage.vue'
import JetButton from '@/Jetstream/Button.vue'
import JetSelect from '@/Jetstream/Select.vue'
import Route from '@/Mixins/Route'
import Spinner from '@/Shared/Svgs/Spinner.vue'
import CheckMarkSolid from '@/Shared/Svgs/CheckMarkSolid.vue'
import CloudDownload from '@/Shared/Svgs/CloudDownload.vue'
import InfoCircleSolid from '@/Shared/Svgs/InfoCircleSolid.vue'
import axios from 'axios'
import WarningSignSolid from '@/Shared/Svgs/WarningSignSolid.vue'
import * as rax from 'retry-axios'

@Component({
  components: {
    WarningSignSolid,
    InfoCircleSolid,
    CloudDownload,
    CheckMarkSolid,
    Spinner,
    JetButton,
    JetActionMessage,
    JetInput,
    JetInputError,
    JetSecondaryButton,
    JetLabel,
    JetFormSection,
    JetSelect,
  },
})
export default class UpdateSettingsForm extends Mixins(Route) {
  @Prop({
    type: String,
    required: true,
  }) currentVersion!: string

  newVersion: string = ''

  checkingVersion: boolean = true

  isUpToDate: boolean = false

  isUpdateAvailable: boolean = false

  isUpdating: boolean = false

  updateFailed: boolean = false

  mounted() {
    this.checkForUpdate()
  }

  async checkForUpdate() {
    const res = await axios.get(this.route('settings.update.check'))

    if (res.data.target !== this.currentVersion && res.data.target !== 'none') {
      this.newVersion = res.data.target
      this.isUpdateAvailable = true
    } else {
      this.isUpToDate = true
    }

    this.checkingVersion = false
  }

  async upgradeCp() {
    this.isUpdating = true
    await axios.get(this.route('settings.upgrade.cp', { timeout: 2000 }))

    const health = await this.waitForUpdate()

    if (health.status === 'OK') {
      this.isUpdating = false
      // eslint-disable-next-line no-restricted-globals
      location.reload()
    } else {
      this.isUpdating = false
      this.updateFailed = true
    }
  }

  async waitForUpdate(): Promise<Record<string, any>> {
    rax.attach(axios)
    const { data: health } = await axios.get(this.route('healthcheck'), {
      raxConfig: {
        retry: 256,
        noResponseRetries: 256,
        retryDelay: 5000,
        backoffType: 'static',
      },
    })

    return health
  }
}

</script>

<style scoped>

</style>
