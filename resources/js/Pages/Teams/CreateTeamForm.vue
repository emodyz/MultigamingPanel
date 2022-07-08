<template>
  <jet-form-section @submitted="createTeam">
    <template #title>
      Team Details
    </template>

    <template #description>
      Create a new team to collaborate with others on projects.
    </template>

    <template #form>
      <div class="col-span-6">
        <jet-label value="Team Owner"/>

        <div class="flex items-center mt-2">
          <img
            class="w-12 h-12 rounded-full object-cover"
            :src="$page.props.user.profile_photo_url"
            :alt="$page.props.user.name"
          >

          <div class="ml-4 leading-tight">
            <div>{{ $page.props.user.name }}</div>
            <div class="text-zinc-700 text-sm">
              {{ $page.props.user.email }}
            </div>
          </div>
        </div>
      </div>

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
          autofocus
        />
        <jet-input-error
          v-if="form.errors.name"
          :message="form.errors.name"
          class="mt-2"
        />
      </div>
    </template>

    <template #actions>
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

import { Mixins, Component } from 'vue-property-decorator'
import Route from '@/Mixins/Route'

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
export default class CreateTeamForm extends Mixins(Route) {
  form = this.$inertia.form({
    name: '',
  })

  createTeam() {
    this.form.post(this.route('teams.store').url(), {
      preserveScroll: true,
      preserveState: true,
      errorBag: 'createTeam',
      onSuccess: () => {
        this.form.reset()
      },
    })
  }
}
</script>
