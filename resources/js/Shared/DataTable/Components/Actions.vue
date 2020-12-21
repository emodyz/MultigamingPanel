<template>
  <div class="text-left text-sm font-medium divide-x divide-gray-200">
    <a
      v-if="actions.show.enabled"
      href="#"
      class="text-green-600 hover:text-green-900 pr-1"
      @click.prevent="goToShow(item.id)"
    >
      {{ actions.show.displayName }}
    </a>
    <a
      v-if="actions.edit.enabled"
      href="#"
      :class="`${actions.show.enabled ? 'pl-2' : ''} pr-1`"
      class="text-indigo-600 hover:text-indigo-900"
      @click.prevent="goToEdit(item.id)"
    >
      {{ actions.edit.displayName }}
    </a>
    <a
      v-if="actions.destroy.enabled"
      href="#"
      :class="`pl-2`"
      class="text-red-600 hover:text-red-900"
      @click.prevent="initiateDestruction(item.id)"
    >
      {{ actions.destroy.displayName }}
    </a>

    <!-- Destroy Action Confirmation Modal -->
    <jet-confirmation-modal
      :show="uuidBeingDestroyed"
      @close="uuidBeingDestroyed = null"
    >
      <template #title>
        Delete
      </template>

      <template #content>
        <div v-if="item.type === 'Users'">
          <span class="text-md">Are you sure you would like to delete this user ?</span>
          <dt-user-profile
            class="my-4"
            :email="item.metaData.email"
            :name="item.metaData.name"
            :profile_photo_url="item.metaData.profile_photo_url"
          />
        </div>
        <div v-else>
          <span class="text-md">Are you sure you would like to delete this item ?</span>
          <br>
          #: {{ uuidBeingDestroyed }}
        </div>
      </template>

      <template #footer>
        <jet-secondary-button @click.native="uuidBeingDestroyed = null">
          Nevermind
        </jet-secondary-button>

        <jet-danger-button
          class="ml-2"
          :class="{ 'opacity-25': destructionInProgress }"
          :disabled="destructionInProgress"
          @click.native="goToDestroy(uuidBeingDestroyed)"
        >
          Delete
        </jet-danger-button>
      </template>
    </jet-confirmation-modal>
  </div>
</template>

<script lang="ts">
import { Vue, Component, Prop } from 'vue-property-decorator'
import { defaultActionsOptions } from '@/Shared/DataTable/Types/defaults.ts'
import { DataTableActionsOptions } from '@/Shared/DataTable/Types/DataTableActionsOptions.d.ts'
import { DataTableActionsItem } from '@/Shared/DataTable/Types/DataTableActionsItem.d.ts'
import { Inertia } from '@inertiajs/inertia'
// import _ from 'lodash'
import jetButton from '@/Jetstream/Button.vue'
import JetDangerButton from '@/Jetstream/DangerButton.vue'
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'
import JetConfirmationModal from '@/Jetstream/ConfirmationModal.vue'
import DtUserProfile from '@/Shared/DataTable/Components/UserProfile.vue'
import CerberusService from '@/Shared/Services/cerberus.service.ts'

@Component({
  components: {
    jetButton,
    JetDangerButton,
    JetSecondaryButton,
    JetConfirmationModal,
    DtUserProfile,
  },
})
// eslint-disable-next-line camelcase
export default class DataTable_Actions extends Vue {
    @Prop({ type: Object, required: true }) readonly item!: DataTableActionsItem

    @Prop({
      type: Object,
      required: true,
      default: () => defaultActionsOptions,
    }) readonly actions!: DataTableActionsOptions

    uuidBeingDestroyed: string | number | null = null

    destructionInProgress = false

    Cerberus = new CerberusService()

    goToShow(id: string | number) {
      Inertia.visit(`${this.actions.baseUrl}/${id}/${this.actions.show.path ? this.actions.show.path : ''}`, { preserveScroll: true })
    }

    goToEdit(id: string | number) {
      Inertia.visit(`${this.actions.baseUrl}/${id}/${this.actions.edit.path}`, { preserveScroll: true })
    }

    initiateDestruction(id: string | number) {
      this.uuidBeingDestroyed = id
    }

    goToDestroy(id: string | number) {
      Inertia.delete(`${this.actions.baseUrl}/${id}/${this.actions.destroy.path ? this.actions.destroy.path : ''}`,
        {
          preserveScroll: true,
          onSuccess: () => {
            this.uuidBeingDestroyed = null
            this.destructionInProgress = false
          },
        })
    }

    async checkPermissions() {
      if (this.actions.show.enabled && this.actions.show.permission) {
        // eslint-disable-next-line no-unused-expressions
        this.actions.show.enabled = await this.Cerberus.can(this.actions.show.permission)
      }
      if (this.actions.edit.enabled && this.actions.edit.permission) {
        // eslint-disable-next-line no-unused-expressions
        this.actions.edit.enabled = await this.Cerberus.can(this.actions.edit.permission)
      }
      if (this.actions.destroy.enabled && this.actions.destroy.permission) {
        // eslint-disable-next-line no-unused-expressions
        this.actions.destroy.enabled = await this.Cerberus.can(this.actions.destroy.permission)
      }
    }

    created() {
      this.checkPermissions()
    }
}
</script>
