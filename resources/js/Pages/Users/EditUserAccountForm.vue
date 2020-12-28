<template>
  <jet-form-section @submitted="editUserAccount">
    <template #title>
      Account Information
    </template>

    <template #description>
      Edit {{ user.name }}'s account information.
    </template>

    <template #form>
      <!-- Email -->
      <div class="col-span-6 sm:col-span-4">
        <jet-label
          for="email"
          value="Email"
        />
        <jet-input
          id="email"
          v-model="form.email"
          type="email"
          class="mt-1 block w-full"
        />
        <jet-input-error
          v-if="!form.recentlySuccessful"
          :message="errorMessages.email"
          class="mt-2"
        />
      </div>

      <!-- Role -->
      <div class="col-span-6 sm:col-span-4">
        <jet-label
          for="role"
          value="Role"
        />
        <select
          id="role"
          v-model="form.role"
          class="mt-1 block w-full rounded-md shadow-sm form-input"
          name="role"
        >
          <option
            value=""
            disabled
            selected
          >
            Choose a role
          </option>
          <option
            v-for="(item, index) in roles"
            :key="index"
            :value="index"
          >
            {{ item.displayName }}
          </option>
        </select>
        <jet-input-error
          v-if="!form.recentlySuccessful"
          :message="errorMessages.role"
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
import JetButton from '@/Jetstream/Button.vue'
import JetFormSection from '@/Jetstream/FormSection.vue'
import JetInput from '@/Jetstream/Input.vue'
import JetInputError from '@/Jetstream/InputError.vue'
import JetLabel from '@/Jetstream/Label.vue'
import JetActionMessage from '@/Jetstream/ActionMessage.vue'
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'

import { Mixins, Component, Prop } from 'vue-property-decorator'

import { User } from '@/Shared/DataTable/Types/User'
import Route from '@/Mixins/Route'

@Component({
  components: {
    JetActionMessage,
    JetButton,
    JetFormSection,
    JetInput,
    JetInputError,
    JetLabel,
    JetSecondaryButton,
  },
})
export default class EditUserProfileForm extends Mixins(Route) {
    @Prop() readonly user!: User

    @Prop() readonly roles!: any

    form: any = {
      email: this.user.email,
      role: this.user.role,
      recentlySuccessful: false,
      processing: false,
    }

    errorMessages = {
      email: '',
      role: '',
      photo: '',
    }

    editUserAccount() {
      this.form.processing = false
      this.form.recentlySuccessful = false

      this.$inertia.put(
        this.route('users.update.account', this.user.id),
        this.form,
        {
          preserveScroll: true,
          resetOnSuccess: false,
          onSuccess: (page: any) => {
            this.form.processing = false
            if (!page.props.errors.editUserAccount) {
              this.form.recentlySuccessful = true
            } else {
              this.errorMessages = page.props.errors.editUserAccount
            }
          },
        },
      )
    }
}
</script>
