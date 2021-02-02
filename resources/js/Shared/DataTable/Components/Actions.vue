<template>
  <div class="text-left text-sm font-medium">
    <div class="divide-x divide-gray-200 dark:divide-gray-700">
      <template v-for="action in options.actions">
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
        <component v-if="!doesNotExist(options.destroyDialog)" :is="options.destroyDialog" :data="item"/>
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
import { Component, Mixins, Prop } from 'vue-property-decorator'
import { Action, DataTableActionsOptions } from '@/Shared/DataTable/Types/DataTableActionsOptions.d'
import { Inertia } from '@inertiajs/inertia'
import jetButton from '@/Jetstream/Button.vue'
import JetDangerButton from '@/Jetstream/DangerButton.vue'
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'
import JetConfirmationModal from '@/Jetstream/ConfirmationModal.vue'
import Helpers from '@/Mixins/Helpers'

@Component({
  components: {
    jetButton,
    JetDangerButton,
    JetSecondaryButton,
    JetConfirmationModal,
  },
})
export default class DataTable_Actions extends Mixins(Helpers) {
  @Prop({
    type: Object,
    required: true,
  }) readonly item!: any

  @Prop({
    type: Object,
    required: true,
  }) readonly options!: DataTableActionsOptions

  uuidBeingDestroyed: string | number | null = null

  actionUsedToDestroy?: Action

  destructionInProgress = false

  // TODO: Refactor action handlers to use named routes

  goToShow(_action: Action) {
    Inertia.visit(`${this.options.baseUrl}/${this.item.id}/${_action.path ? _action.path : ''}`, { preserveScroll: true })
  }

  goToEdit(_action: Action) {
    Inertia.visit(`${this.options.baseUrl}/${this.item.id}/${_action.path}`, { preserveScroll: true })
  }

  initiateDestruction(_action: Action) {
    this.uuidBeingDestroyed = this.item.id
    this.actionUsedToDestroy = _action
  }

  goToDestroy(_action: Action) {
    Inertia.delete(`${this.options.baseUrl}/${this.item.id}/${_action.path ? _action.path : ''}`,
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
