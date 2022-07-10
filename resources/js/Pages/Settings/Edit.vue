<template>
  <app-layout>
    <template #header>
      <h2 class="breadcrumb">
        Settings <span class="breadcrumb-separator">/</span> Edit
      </h2>
    </template>

    <div>
      <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <update-settings-form
            :current-version="currentVersion"
        />

        <jet-section-border/>

        <voice-settings-form
            :settings="voiceSettings"
        />
      </div>
    </div>
  </app-layout>
</template>

<script lang="ts">

import { Component, Prop, Vue } from 'vue-property-decorator'
import AppLayout from '@/Layouts/AppLayout.vue'
import JetSectionBorder from '@/Jetstream/SectionBorder.vue'
import VoiceSettingsForm from '@/Pages/Settings/Components/VoiceSettingsForm.vue'
import UpdateSettingsForm from '@/Pages/Settings/Components/UpdateSettingsForm.vue'

@Component({
  components: {
    VoiceSettingsForm,
    UpdateSettingsForm,
    AppLayout,
    JetSectionBorder,
  },
})
export default class Settings_Index extends Vue {
  @Prop({
    type: Object,
    required: true,
    default: null,
  }) voiceSettings!: any

  @Prop({
    type: String,
    required: true,
    default: '',
  }) currentVersion!: string

  mounted() {
    // console.log('cc')
  }
}
</script>

<style scoped>

</style>
