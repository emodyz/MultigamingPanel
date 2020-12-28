<template>
  <div>
    <!-- Generate API Token -->
    <jet-form-section @submitted="createApiToken">
      <template #title>
        Create API Token
      </template>

      <template #description>
        API tokens allow third-party services to authenticate with our application on your behalf.
      </template>

      <template #form>
        <!-- Token Name -->
        <div class="col-span-6 sm:col-span-4">
          <jet-label
            for="name"
            value="Name"
          />
          <jet-input
            id="name"
            v-model="createApiTokenForm.name"
            type="text"
            class="mt-1 block w-full"
            autofocus
          />
          <jet-input-error
            v-if="!createApiTokenForm.recentlySuccessful"
            :message="createApiTokenForm.errors.name"
            class="mt-2"
          />
        </div>

        <!-- Token Permissions -->
        <div
          v-if="availablePermissions.length > 0"
          class="col-span-6"
        >
          <jet-label
            for="permissions"
            value="Permissions"
          />

          <div class="mt-2 grid grid-cols-1 md:grid-cols-2 gap-4">
            <div
              v-for="permission in availablePermissions"
              :key="permission"
            >
              <label class="flex items-center">
                <input
                  v-model="createApiTokenForm.permissions"
                  type="checkbox"
                  class="form-checkbox"
                  :value="permission"
                >
                <span class="ml-2 text-sm text-gray-600">{{ permission }}</span>
              </label>
            </div>
          </div>
        </div>
      </template>

      <template #actions>
        <jet-action-message
          :on="createApiTokenForm.recentlySuccessful"
          class="mr-3"
        >
          Created.
        </jet-action-message>

        <jet-button
          :class="{ 'opacity-25': createApiTokenForm.processing }"
          :disabled="createApiTokenForm.processing"
        >
          Create
        </jet-button>
      </template>
    </jet-form-section>

    <div v-if="tokens.length > 0">
      <jet-section-border />

      <!-- Manage API Tokens -->
      <div class="mt-10 sm:mt-0">
        <jet-action-section>
          <template #title>
            Manage API Tokens
          </template>

          <template #description>
            You may delete any of your existing tokens if they are no longer needed.
          </template>

          <!-- API Token List -->
          <template #content>
            <div class="space-y-6">
              <div
                v-for="token in tokens"
                :key="token.id"
                class="flex items-center justify-between"
              >
                <div>
                  {{ token.name }}
                </div>

                <div class="flex items-center">
                  <div
                    v-if="token.last_used_at"
                    class="text-sm text-gray-400"
                  >
                    Last used {{ fromNow(token.last_used_at) }}
                  </div>

                  <button
                    v-if="availablePermissions.length > 0"
                    class="cursor-pointer ml-6 text-sm text-gray-400 underline focus:outline-none"
                    @click="manageApiTokenPermissions(token)"
                  >
                    Permissions
                  </button>

                  <button
                    class="cursor-pointer ml-6 text-sm text-red-500 focus:outline-none"
                    @click="confirmApiTokenDeletion(token)"
                  >
                    Delete
                  </button>
                </div>
              </div>
            </div>
          </template>
        </jet-action-section>
      </div>
    </div>

    <!-- Token Value Modal -->
    <jet-dialog-modal
      :show="displayingToken"
      @close="displayingToken = false"
    >
      <template #title>
        API Token
      </template>

      <template #content>
        <div>
          Please copy your new API token. For your security, it won't be shown again.
        </div>

        <div
          v-if="$page.props.jetstream.flash.token"
          class="mt-4 bg-gray-100 px-4 py-2 rounded font-mono text-sm text-gray-500"
        >
          {{ $page.props.jetstream.flash.token }}
        </div>
      </template>

      <template #footer>
        <jet-secondary-button @click.native="displayingToken = false">
          Close
        </jet-secondary-button>
      </template>
    </jet-dialog-modal>

    <!-- API Token Permissions Modal -->
    <jet-dialog-modal
      :show="managingPermissionsFor"
      @close="managingPermissionsFor = null"
    >
      <template #title>
        API Token Permissions
      </template>

      <template #content>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div
            v-for="permission in availablePermissions"
            :key="permission"
          >
            <label class="flex items-center">
              <input
                v-model="updateApiTokenForm.permissions"
                type="checkbox"
                class="form-checkbox"
                :value="permission"
              >
              <span class="ml-2 text-sm text-gray-600">{{ permission }}</span>
            </label>
          </div>
        </div>
      </template>

      <template #footer>
        <jet-secondary-button @click.native="managingPermissionsFor = null">
          Nevermind
        </jet-secondary-button>

        <jet-button
          class="ml-2"
          :class="{ 'opacity-25': updateApiTokenForm.processing }"
          :disabled="updateApiTokenForm.processing"
          @click.native="updateApiToken"
        >
          Save
        </jet-button>
      </template>
    </jet-dialog-modal>

    <!-- Delete Token Confirmation Modal -->
    <jet-confirmation-modal
      :show="apiTokenBeingDeleted"
      @close="apiTokenBeingDeleted = null"
    >
      <template #title>
        Delete API Token
      </template>

      <template #content>
        Are you sure you would like to delete this API token?
      </template>

      <template #footer>
        <jet-secondary-button @click.native="apiTokenBeingDeleted = null">
          Nevermind
        </jet-secondary-button>

        <jet-danger-button
          class="ml-2"
          :class="{ 'opacity-25': deleteApiTokenForm.processing }"
          :disabled="deleteApiTokenForm.processing"
          @click.native="deleteApiToken"
        >
          Delete
        </jet-danger-button>
      </template>
    </jet-confirmation-modal>
  </div>
</template>

<script lang="ts">
import JetActionMessage from '@/Jetstream/ActionMessage.vue'
import JetActionSection from '@/Jetstream/ActionSection.vue'
import JetButton from '@/Jetstream/Button.vue'
import JetConfirmationModal from '@/Jetstream/ConfirmationModal.vue'
import JetDangerButton from '@/Jetstream/DangerButton.vue'
import JetDialogModal from '@/Jetstream/DialogModal.vue'
import JetFormSection from '@/Jetstream/FormSection.vue'
import JetInput from '@/Jetstream/Input.vue'
import JetInputError from '@/Jetstream/InputError.vue'
import JetLabel from '@/Jetstream/Label.vue'
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'
import JetSectionBorder from '@/Jetstream/SectionBorder.vue'

import { Mixins, Component, Prop } from 'vue-property-decorator'
import Route from '@/Mixins/Route'

    @Component({
      components: {
        JetActionMessage,
        JetActionSection,
        JetButton,
        JetConfirmationModal,
        JetDangerButton,
        JetDialogModal,
        JetFormSection,
        JetInput,
        JetInputError,
        JetLabel,
        JetSecondaryButton,
        JetSectionBorder,
      },
    })
export default class ApiTokenManager extends Mixins(Route) {
        @Prop() tokens!: any

        @Prop() availablePermissions!: any

        @Prop() defaultPermissions!: any

        createApiTokenForm: any = {
          name: '',
          permissions: this.defaultPermissions,
          processing: false,
          recentlySuccessful: false,
          errors: {
            name: '',
          },
        }

        updateApiTokenForm: any = {
          permissions: [],
          processing: false,
          recentlySuccessful: false,
          errors: {
            permissions: '',
          },
        }

        deleteApiTokenForm: any = {
          processing: false,
        }

        displayingToken: boolean = false

        managingPermissionsFor: any = null

        apiTokenBeingDeleted: any = null

        createApiToken() {
          this.createApiTokenForm.recentlySuccessful = false

          this.$inertia.post(
            this.route('api-tokens.store'),
            this.createApiTokenForm,
            {
              preserveScroll: true,
              onSuccess: () => {
                // @ts-ignore
                if (!this.$page.props.errors.createApiToken) {
                  this.displayingToken = true
                  this.createApiTokenForm.recentlySuccessful = true
                  this.createApiTokenForm.name = ''
                  this.createApiTokenForm.permissions = this.defaultPermissions
                } else {
                  // @ts-ignore
                  this.createApiTokenForm.errors.name = this.$page.props.errors.createApiToken.name
                }
              },
            },
          )
        }

        manageApiTokenPermissions(token: any) {
          this.updateApiTokenForm.permissions = token.abilities

          this.managingPermissionsFor = token
        }

        updateApiToken() {
          this.updateApiTokenForm.processing = true

          this.$inertia.put(
            this.route('api-tokens.update', this.managingPermissionsFor),
            this.updateApiTokenForm,
            {
              preserveScroll: true,
              preserveState: true,
              onSuccess: () => {
                this.managingPermissionsFor = null
                this.updateApiTokenForm.processing = false
              },
            },
          )
        }

        confirmApiTokenDeletion(token: any) {
          this.apiTokenBeingDeleted = token
        }

        deleteApiToken() {
          this.$inertia.delete(
            this.route('api-tokens.destroy', this.apiTokenBeingDeleted),
            {
              preserveScroll: true,
              preserveState: true,
              onSuccess: () => {
                this.apiTokenBeingDeleted = null
              },
            },
          )
        }

        fromNow(timestamp: any) {
          // @ts-ignore
          return moment(timestamp).local().fromNow()
        }
}
</script>
