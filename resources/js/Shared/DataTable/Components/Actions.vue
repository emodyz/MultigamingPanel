<template>
  <div class="text-left text-sm font-medium divide-x divide-gray-200">
    <a
      v-if="actions.show.enabled"
      href="#"
      :class="`text-${actions.show.color} hover:text-${actions.show.hvColor} pr-1`"
      @click.prevent="goToShow(item.id)"
    >
      {{ actions.show.displayName }}
    </a>
    <a
      v-if="actions.edit.enabled"
      href="#"
      :class="`text-${actions.edit.color} hover:text-${actions.edit.hvColor} ${actions.show.enabled ? 'pl-2' : ''} pr-1`"
      @click.prevent="goToEdit(item.id)"
    >
      {{ actions.edit.displayName }}
    </a>
    <a
      v-if="actions.destroy.enabled"
      href="#"
      :class="`text-${actions.destroy.color} hover:text-${actions.destroy.hvColor} pl-2`"
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
import _ from 'lodash'
import jetButton from '@/Jetstream/Button.vue'
import JetDangerButton from '@/Jetstream/DangerButton.vue'
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'
import JetConfirmationModal from '@/Jetstream/ConfirmationModal.vue'
import DtUserProfile from '@/Shared/DataTable/Components/UserProfile.vue'

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

    @Prop({ required: true }) readonly UserPermissions!: Array<string> | null

    @Prop({
      type: Object,
      required: true,
      default: () => defaultActionsOptions,
    }) readonly actions!: DataTableActionsOptions

    uuidBeingDestroyed: string | number | null = null

    destructionInProgress = false

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

    checkPermissions() {
      if (this.actions.show.enabled && this.actions.show.permission) {
        // eslint-disable-next-line no-unused-expressions
        !(_.includes(this.UserPermissions, this.actions.show.permission)) && !(_.includes(this.UserPermissions, '*')) ? this.actions.show.enabled = false : null
      }
      if (this.actions.edit.enabled && this.actions.edit.permission) {
        // eslint-disable-next-line no-unused-expressions
        !(_.includes(this.UserPermissions, this.actions.edit.permission)) && !(_.includes(this.UserPermissions, '*')) ? this.actions.edit.enabled = false : null
      }
      if (this.actions.destroy.enabled && this.actions.destroy.permission) {
        // eslint-disable-next-line no-unused-expressions
        !(_.includes(this.UserPermissions, this.actions.destroy.permission)) && !(_.includes(this.UserPermissions, '*')) ? this.actions.destroy.enabled = false : null
      }
    }

    created() {
      this.checkPermissions()
    }
}
</script>
