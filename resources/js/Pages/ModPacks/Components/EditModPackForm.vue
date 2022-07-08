<template>
    <monolithic-form-section @submitted="submitForm">
        <template #title>
            Edit this modpack
        </template>

        <template #description>
            Edit the name
            <required/>
            , path (optional) and
            disk (coming soon) of this modpack.
        </template>

        <template #form>
            <!-- Title -->
            <div class="col-span-6">
                <jet-label
                        for="name"
                        value="Name"
                />
                <jet-input
                        id="name"
                        v-model="form.name"
                        autocomplete="name"
                        class="mt-1 block w-full"
                        maxlength="80"
                        placeholder="My Amazing Name..."
                        type="text"
                />
                <jet-input-error
                        v-if="form.errors.name"
                        :message="form.errors.name"
                        class="mt-2"
                />
            </div>

            <div class="col-span-6">
                <jet-label
                        for="path"
                        value="Path"
                />
                <jet-input
                        id="path"
                        v-model="form.path"
                        autocomplete="path"
                        class="mt-1 block w-full"
                        maxlength="80"
                        placeholder="ModPack (server) path..."
                        type="text"
                />
                <jet-input-error
                        v-if="form.errors.path"
                        :message="form.errors.path"
                        class="mt-2"
                />
            </div>

            <div class="col-span-6">
                <jet-label
                        for="disk"
                        value="Game (cannot be changed)"
                />
                <jet-input
                        id="game"
                        :disabled="true"
                        v-model="form.game"
                        autocomplete="game"
                        class="mt-1 block w-full bg-gray-200 cursor-not-allowed"
                        maxlength="80"
                        placeholder="Modpack Game"
                        type="text"
                />
                <jet-input-error
                        v-if="form.errors.game"
                        :message="form.errors.game"
                        class="mt-2"
                />
            </div>

            <div class="col-span-6">
                <jet-label
                        for="disk"
                        value="Disk (not supported yet)"
                />
                <jet-input
                        id="disk"
                        :disabled="true"
                        v-model="form.disk"
                        autocomplete="disk"
                        class="mt-1 block w-full bg-gray-200 cursor-not-allowed"
                        maxlength="80"
                        placeholder="My Amazing Disk..."
                        type="text"
                />
                <jet-input-error
                        v-if="form.errors.disk"
                        :message="form.errors.disk"
                        class="mt-2"
                />
            </div>
        </template>

        <template #customInputs>
            <jet-section-border padding="pb-5"/>
            <!-- Link Servers -->
            <monolithic-form-input-card>
                <template #label>
                    <jet-section-title class="pb-6">
                        <template #title>
                            Link to a server
                        </template>
                        <template #description>
                            You can chose to link this modpack to one or more servers
                        </template>
                    </jet-section-title>
                </template>

                <template #input>
                    <div class="col-span-6 sm:col-span-4">
                        <multi-select
                                v-model="form.servers"
                                :options-list="serversOptions"
                                :tags="true"
                                placeholder="Chose a server"
                        />
                    </div>
                </template>
            </monolithic-form-input-card>
        </template>

        <template #actions>
            <jet-action-message
                    :on="form.recentlySuccessful"
                    class="mr-3"
            >
                {{ formSuccessMsg }}
            </jet-action-message>

            <jet-secondary-button
                    @click="goToUpdate"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    class="mr-3"
                    type="button"
            >
                Manage Updates
            </jet-secondary-button>

            <jet-button
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    class="mr-3"
                    type="submit"
            >
                Save
            </jet-button>
        </template>
    </monolithic-form-section>
</template>

<script lang="ts">
import { Component, Mixins, Prop } from 'vue-property-decorator'
import MonolithicFormSection from '@/Shared/Forms/MonolithicFormSection.vue'
import MonolithicFormInputCard from '@/Shared/Forms/MonolithicFormInputCard.vue'
import JetLabel from '@/Jetstream/Label.vue'
import JetInput from '@/Jetstream/Input.vue'
import JetInputError from '@/Jetstream/InputError.vue'
import JetActionMessage from '@/Jetstream/ActionMessage.vue'
import JetButton from '@/Jetstream/Button.vue'
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'
import JetSectionBorder from '@/Jetstream/SectionBorder.vue'
import JetSectionTitle from '@/Jetstream/SectionTitle.vue'
import JetDropdown from '@/Jetstream/Dropdown.vue'
import MultiSelect from '@/Shared/Forms/MultiSelect.vue'
import { MultiSelectOptions } from '@/Shared/Forms/Types/MultiSelectOptions'

import Route from '@/Mixins/Route'
import Required from '@/Shared/Forms/Required.vue'

import MultiSelectServerRow from '@/Shared/Forms/MultiSelectServerRow.vue'

@Component({
  components: {
    MonolithicFormSection,
    MonolithicFormInputCard,
    Required,
    MultiSelect,
    JetLabel,
    JetInput,
    JetInputError,
    JetActionMessage,
    JetButton,
    JetSecondaryButton,
    JetSectionBorder,
    JetSectionTitle,
    JetDropdown,
  },
})
export default class EditModPackForm extends Mixins(Route) {
  @Prop({
    type: Object,
    required: true,
  }) modpack!: any

  @Prop() readonly servers !: Array<any>

  serversOptions: MultiSelectOptions = this.initServerOptions()

  form = this.$inertia.form({
    name: this.modpack.name,
    path: this.modpack.path,
    game: this.modpack.game.name,
    disk: this.modpack.disk,
    servers: this.modpack.server,
  })

  formSuccessMsg = 'Saved.'

  goToUpdate() {
    this.$inertia.visit(this.route('modpacks.update.show', this.modpack.id).url())
  }

  submitForm() {
    this.form.put(
      this.route('modpacks.update', this.modpack.id).url(),
      {
        preserveScroll: true,
        preserveState: true,
      },
    )
  }

  getLinkedServersIds() {
    const lsids: any[] = []
    this.modpack.servers.forEach((s: any) => {
      lsids.push(s.id)
    })
    return lsids
  }

  isServerLinked(server: any): boolean {
    return !!this.modpack.servers.find((e: any) => e.id === server.id)
  }

  initServerOptions(): MultiSelectOptions {
    const opts: MultiSelectOptions = []
    this.servers.forEach((server: any) => {
      opts.push({
        name: server.name,
        value: server.id,
        selected: this.isServerLinked(server),
        component: {
          instance: MultiSelectServerRow,
          properties: {
            logo: server.logo_url,
            game: {
              name: server.game.name,
              logo: server.game.logo_url,
              identifier: server.game.identifier,
            },
          },
        },
      })
    })
    return opts
  }
}
</script>

<style scoped>

</style>
