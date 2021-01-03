<template>
  <div class="text-left text-sm font-medium">
    <div class="divide-x divide-gray-200">
      <template v-for="action in actionsOptions.actions">
        <a
            v-if="action.enabled"
            :key="action.displayName"
            href="#"
            class="px-1"
            :class="action.class"
            @click.prevent="goTo(action)"
        >
          {{ action.displayName }}
        </a>
      </template>
    </div>
    <!-- Destroy Action Confirmation Modal -->
    <jet-confirmation-modal
        :show="uuidBeingDestroyed"
        @close="uuidBeingDestroyed = null"
    >
      <template #title>
        Delete
      </template>

      <template #content>
        <!-- TODO: handle action model content with injectable dynamic components -->
        <div v-if="item.type === 'Users'">
          <span class="text-md">Are you sure you would like to delete this user ?</span>
          <dt-user-profile
              class="my-4"
              :email="item.metaData.email"
              :name="item.metaData.name"
              :profile_photo_url="item.metaData.profile_photo_url"
          />
        </div>
          <div v-if="item.type === 'ModPacks'">
              <div class="p-3 rounded-md bg-red-500 text-red-50 font-semibold">
                  This action will delete all modpacks files !
              </div>
              <div class="my-3">
                  <span class="text-md">Are you sure you would like to delete this modpack ?</span>
              </div>
              <div class="flex justify-between items-center border rounded-md p-3">
                  <div class="flex flex-col text-sm">
                      <div>
                        <span class="font-medium">Name:</span>
                        <span class="font-bold">{{ item.metaData.name }}</span>
                      </div>
                      <div>
                        <span class="font-medium">Assigned Servers:</span>
                        <span class="font-bold">{{ item.metaData.servers.length }}</span>
                      </div>
                      <div>
                          <span class="font-medium">Size:</span>
                          <DtModPackSize class="inline-flex" :size="item.metaData.manifest_info.size"></DtModPackSize>
                      </div>
                  </div>
                  <dt-game-profile :name="item.metaData.game.name" :logo_url="item.metaData.game.logo_url"></dt-game-profile>

              </div>
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
            @click.native="goToDestroy(actionUsedToDestroy)"
        >
          Delete
        </jet-danger-button>
      </template>
    </jet-confirmation-modal>
  </div>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator'
import { defaultActionsOptions } from '@/Shared/DataTable/Types/defaults'
import { Action, DataTableActionsOptions } from '@/Shared/DataTable/Types/DataTableActionsOptions'
import { DataTableActionsItem } from '@/Shared/DataTable/Types/DataTableActionsItem'
import { Inertia } from '@inertiajs/inertia'
import jetButton from '@/Jetstream/Button.vue'
import JetDangerButton from '@/Jetstream/DangerButton.vue'
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'
import JetConfirmationModal from '@/Jetstream/ConfirmationModal.vue'
import DtUserProfile from '@/Shared/DataTable/Components/UserProfile.vue'
import DtGameProfile from '@/Shared/DataTable/Components/GameProfile.vue'
import DtModPackSize from '@/Shared/DataTable/Components/ModPackSize.vue'

@Component({
  components: {
    jetButton,
    JetDangerButton,
    JetSecondaryButton,
    JetConfirmationModal,
    DtUserProfile,
    DtGameProfile,
    DtModPackSize,
  },
})
// eslint-disable-next-line camelcase
export default class DataTable_Actions extends Vue {
  @Prop({
    type: Object,
    required: true,
  }) readonly item!: DataTableActionsItem

  @Prop({
    type: Object,
    required: true,
    default: () => defaultActionsOptions,
  }) readonly actionsOptions!: DataTableActionsOptions

  uuidBeingDestroyed: string | number | null = null

  actionUsedToDestroy?: Action

  destructionInProgress = false

  goToShow(_action: Action) {
    Inertia.visit(`${this.actionsOptions.baseUrl}/${this.item.id}/${_action.path ? _action.path : ''}`, { preserveScroll: true })
  }

  goToEdit(_action: Action) {
    Inertia.visit(`${this.actionsOptions.baseUrl}/${this.item.id}/${_action.path}`, { preserveScroll: true })
  }

  initiateDestruction(_action: Action) {
    this.uuidBeingDestroyed = this.item.id
    this.actionUsedToDestroy = _action
  }

  goToDestroy(_action: Action) {
    Inertia.delete(`${this.actionsOptions.baseUrl}/${this.item.id}/${_action.path ? _action.path : ''}`,
      {
        preserveScroll: true,
        onSuccess: () => {
          this.uuidBeingDestroyed = null
          this.actionUsedToDestroy = null
          this.destructionInProgress = false
        },
      })
  }

  goTo(_action: Action) {
    switch (_action.type) {
      case 'edit':
        this.goToEdit(_action)
        break
      case 'destroy':
        this.initiateDestruction(_action)
        break
      default:
        this.goToShow(_action)
    }
  }
}
</script>
