<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Settings <span class="text-gray-400">/</span> Edit
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">

                <voice-settings-form
                        :settings="voiceSettings"
                />

                <!--<jet-section-border />-->

            </div>
        </div>
    </app-layout>
</template>

<script lang="ts">

import { Component, Prop, Vue } from 'vue-property-decorator'
import AppLayout from '@/Layouts/AppLayout.vue'
import JetSectionBorder from '@/Jetstream/SectionBorder'
import VoiceSettingsForm from '@/Pages/Settings/Components/VoiceSettingsForm.vue'

@Component({
  components: {
    VoiceSettingsForm,
    AppLayout,
    JetSectionBorder,
  },
})
export default class Settings_Index extends Vue {
  @Prop({ type: Object, required: true, default: null }) voiceSettings!: any;

  mounted() {
    // console.log('cc')
  }
}
</script>

<style scoped>

</style>
