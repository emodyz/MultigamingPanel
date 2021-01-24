<template>
    <jet-form-section @submitted="updateVoiceSettings">
        <template #title>
            Voice Settings
        </template>

        <template #description>
            Update your voice provider
        </template>

        <template #form>

            <!-- Name -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label
                        for="type"
                        value="Select your voice provider"
                />
                <jet-select
                        id="type"
                        v-model="form.type"
                        :options="availableVoiceOptions()"
                        placeholder="No provider"
                        class="mt-1 block w-full"
                        can-be-null
                />
                <jet-input-error
                        v-if="form.errors.type"
                        :message="form.errors.type"
                        class="mt-2"
                />
            </div>

            <component :form="form" :is="getVoiceComponent()"></component>
        </template>

        <template #actions>
            <jet-action-message
                    :on="form.recentlySuccessful"
                    class="mr-3">
                Saved.
            </jet-action-message>
            <jet-secondary-button
                    type="button"
                    @click="reset"
                    class="mr-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing">
                Reset
            </jet-secondary-button>

            <jet-button
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing">
                Save
            </jet-button>
        </template>
    </jet-form-section>
</template>

<script lang="ts">
import {
  Component, Mixins, Prop, Watch,
} from 'vue-property-decorator'
import JetFormSection from '@/Jetstream/FormSection.vue'
import JetLabel from '@/Jetstream/Label.vue'
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'
import JetInputError from '@/Jetstream/InputError.vue'
import JetInput from '@/Jetstream/Input.vue'
import JetActionMessage from '@/Jetstream/ActionMessage.vue'
import JetButton from '@/Jetstream/Button.vue'
import JetSelect, { SelectOption } from '@/Jetstream/Select.vue'
import Route from '@/Mixins/Route'
import DiscordForm from '@/Pages/Settings/Components/DiscordForm.vue'
import TeamSpeak3Form from '@/Pages/Settings/Components/Teamspeak3Form.vue'

@Component({
  components: {
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
export default class VoiceSettingsForm extends Mixins(Route) {
  @Prop({
    type: Object,
    required: true,
  }) settings!: any;

  form = this.$inertia.form({
    type: this.settings.type,
    payload: this.settings.payload,
  })

  @Watch('settings')
  onSettingsUpdated(settings: any) {
    this.form.type = settings.type
    this.$nextTick(() => {
      this.form.payload = settings.payload
    })
  }

  @Watch('form.type')
  onVoiceTypeUpdated() {
    this.form.payload = {}
  }

  async updateVoiceSettings() {
    await this.form.put(this.route('settings.update.voice'))
  }

  reset() {
    this.$inertia.reload({
      only: ['voiceSettings'],
    })
  }

  getVoiceComponent() {
    switch (this.form.type) {
      case 'discord':
        return DiscordForm
      case 'teamspeak3':
        return TeamSpeak3Form
      default:
        return null
    }
  }

  availableVoiceOptions(): SelectOption[] {
    return [
      {
        value: 'discord',
        display: 'Discord',
      },
      {
        value: 'teamspeak3',
        display: 'Teamspeak 3',
      },
    ]
  }
}

</script>

<style scoped>

</style>
