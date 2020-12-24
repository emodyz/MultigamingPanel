<template>
  <jet-form-section @submitted="updateTeamName">
    <template #title>
      Team Name
    </template>

    <template #description>
      The team's name and owner information.
    </template>

    <template #form>
      <!-- Team Owner Information -->
      <div class="col-span-6">
        <jet-label value="Team Owner" />

        <div class="flex items-center mt-2">
          <img
            class="w-12 h-12 rounded-full object-cover"
            :src="team.owner.profile_photo_url"
            :alt="team.owner.name"
          >

          <div class="ml-4 leading-tight">
            <div>{{ team.owner.name }}</div>
            <div class="text-gray-700 text-sm">
              {{ team.owner.email }}
            </div>
          </div>
        </div>
      </div>

      <!-- Team Name -->
      <div class="col-span-6 sm:col-span-4">
        <jet-label
          for="name"
          value="Team Name"
        />

        <jet-input
          id="name"
          v-model="form.name"
          type="text"
          class="mt-1 block w-full"
          :disabled="! permissions.canUpdateTeam"
        />

        <jet-input-error
          v-if="!form.recentlySuccessful"
          :message="form.errors.name"
          class="mt-2"
        />
      </div>
    </template>

    <template
      v-if="permissions.canUpdateTeam"
      #actions
    >
      <jet-action-message
        :on="form.recentlySuccessful"
        class="mr-3"
      >
        Saved.
      </jet-action-message>

      <jet-button
        :class="{ 'opacity-25': form.processing }"
        :disabled="form.processing"
      >
        Save
      </jet-button>
    </template>
  </jet-form-section>
</template>

<script lang="ts">
import JetActionMessage from '@/Jetstream/ActionMessage.vue'
import JetButton from '@/Jetstream/Button.vue'
import JetFormSection from '@/Jetstream/FormSection.vue'
import JetInput from '@/Jetstream/Input.vue'
import JetInputError from '@/Jetstream/InputError.vue'
import JetLabel from '@/Jetstream/Label.vue'

import { Vue, Component, Prop } from 'vue-property-decorator'

    @Component({
      components: {
        JetActionMessage,
        JetButton,
        JetFormSection,
        JetInput,
        JetInputError,
        JetLabel,
      },
    })
export default class UpdateTeamNameForm extends Vue {
        @Prop() readonly team!: any

        @Prop() permissions!: any

        @Prop() readonly errors!: any

        form: any = {
          name: this.team.name,
          processing: false,
          recentlySuccessful: false,
          errors: {
            name: '',
          },
        }

        updateTeamName() {
          this.form.processing = true
          this.form.recentlySuccessful = false
          // @ts-ignore
          this.$inertia.put(
            // @ts-ignore
            route('teams.update', this.team),
            this.form,
            {
              preserveScroll: true,
              onSuccess: () => {
                this.form.processing = false
                // @ts-ignore
                if (!this.$page.props.errors.updateTeamName) {
                  this.form.recentlySuccessful = true
                } else {
                  // @ts-ignore
                  this.form.errors = this.$page.props.errors.updateTeamName
                }
              },
            },
          )
        }
}
</script>
