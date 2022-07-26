<template>
  <jet-form-section>
    <template #title>
      Update Settings
    </template>

    <template #description>
      Update your voice provider
    </template>

    <template #form>

      <!-- Name -->
      <div class="col-span-6 sm:col-span-4">
        <div class="inline-flex items-center text-zinc-700 dark:text-zinc-300">
          <spinner v-show="checkingVersion" class="h-7 w-7 mr-4 text-indigo-500"/>
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
        <div class="w-full">
          <jet-button class="mt-6 ml-11 inline-flex items-center">
            <cloud-download class="mr-2"/> UPDATE
          </jet-button>
        </div>
      </div>
    </template>
  </jet-form-section>
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

@Component({
  components: {
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

  isUpdateAvailable: boolean = !(this.checkingVersion && this.isUpToDate)

  mounted() {
    this.checkForUpdate()
  }

  async checkForUpdate() {
    const res = await axios.get(this.route('settings.update.check'))

    if (res.data.target !== this.currentVersion && res.data.target !== 'none') {
      this.newVersion = res.data.target
    } else {
      this.isUpToDate = true
    }

    this.checkingVersion = false
  }
}

</script>

<style scoped>

</style>
