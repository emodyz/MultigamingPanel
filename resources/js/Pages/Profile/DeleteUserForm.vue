<template>
  <jet-action-section>
    <template #title>
      Delete Account
    </template>

    <template #description>
      Permanently delete your account.
    </template>

    <template #content>
      <div class="max-w-xl text-sm text-gray-600">
        Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.
      </div>

      <div class="mt-5">
        <jet-danger-button @click.native="confirmUserDeletion">
          Delete Account
        </jet-danger-button>
      </div>

      <!-- Delete Account Confirmation Modal -->
      <jet-dialog-modal
        :show="confirmingUserDeletion"
        @close="confirmingUserDeletion = false"
      >
        <template #title>
          Delete Account
        </template>

        <template #content>
          Are you sure you want to delete your account? Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.

          <div class="mt-4">
            <jet-input
              ref="password"
              v-model="form.password"
              type="password"
              class="mt-1 block w-3/4"
              placeholder="Password"
              @keyup.enter.native="deleteUser"
            />

            <jet-input-error
              v-if="!form.recentlySuccessful"
              :message="errorMessages.password"
              class="mt-2"
            />
          </div>
        </template>

        <template #footer>
          <jet-secondary-button @click.native="confirmingUserDeletion = false">
            Nevermind
          </jet-secondary-button>

          <jet-danger-button
            class="ml-2"
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
            @click.native="deleteUser"
          >
            Delete Account
          </jet-danger-button>
        </template>
      </jet-dialog-modal>
    </template>
  </jet-action-section>
</template>

<script lang="ts">
import JetActionSection from '@/Jetstream/ActionSection.vue'
import JetDangerButton from '@/Jetstream/DangerButton.vue'
import JetDialogModal from '@/Jetstream/DialogModal.vue'
import JetInput from '@/Jetstream/Input.vue'
import JetInputError from '@/Jetstream/InputError.vue'
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'

import {
  Vue, Component, Ref,
} from 'vue-property-decorator'

    @Component({
      components: {
        JetActionSection,
        JetDangerButton,
        JetDialogModal,
        JetInput,
        JetInputError,
        JetSecondaryButton,
      },
    })
export default class DeleteUserForm extends Vue {
        @Ref('password') readonly password!: any

        errorMessages = {
          password: '',
        }

        confirmingUserDeletion = false

        form = {
          password: '',
          processing: false,
          recentlySuccessful: false,
        }

        confirmUserDeletion() {
          this.form.password = ''

          this.confirmingUserDeletion = true

          setTimeout(() => {
            this.password.focus()
          }, 250)
        }

        deleteUser() {
          this.form.processing = true
          this.form.recentlySuccessful = false
          // @ts-ignore
          this.$inertia.delete(
            // @ts-ignore
            route('current-user.destroy'),
            {
              data: this.form,
              preserveScroll: true,
              // eslint-disable-next-line no-unused-vars
              onSuccess: (page: any) => {
                // @ts-ignore
                this.form.processing = false
                // @ts-ignore
                if (!this.$page.props.errors.deleteUser) {
                  this.confirmingUserDeletion = false
                  this.form.recentlySuccessful = true
                } else {
                  // @ts-ignore
                  this.errorMessages = this.$page.props.errors.deleteUser
                }
              },
            },
          )
        }
}
</script>
