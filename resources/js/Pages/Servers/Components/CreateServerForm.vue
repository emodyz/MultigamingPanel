<template>
  <div>
    <monolithic-form-section @submitted="submitForm">
      <template #title>
        Create a new server
      </template>

      <template #description>
        Name it
        <required/>
      </template>

      <template #form>
        <!-- Name -->
        <div class="col-span-6 sm:col-span-4">
          <jet-label
              for="name"
              value="Name"
          />
          <jet-input
              id="name"
              v-model="form.name"
              type="text"
              maxlength="80"
              placeholder="My Amazing Name..."
              class="mt-1 block w-full"
              autocomplete="name"
              required
          />
          <jet-input-error
              v-if="form.errors.name"
              :message="form.errors.name"
              class="mt-2"
          />
        </div>
      </template>

      <template #customInputs>
        <jet-section-border padding="pb-5"/>
        <!-- Server Logo -->
        <monolithic-form-input-card>
          <template #label>
            <jet-section-title class="pb-6">
              <template #title>
                Logo
              </template>
              <template #description>
                Add a Logo to distinguish this server
              </template>
            </jet-section-title>
          </template>
          <template #input>
            <div class="col-span-6">
              <!-- Logo File Input -->
              <input
                  ref="logo"
                  type="file"
                  class="hidden"
                  @change="updateLogoPreview"
              >
              <!-- Logo Preview -->
              <div
                  v-show="logoPreview"
                  class="mb-6"
              >
                <span
                  class="block rounded-lg w-40 h-40 shadow-lg"
                  :style="'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + logoPreview + '\');'"
                />
              </div>

              <jet-secondary-button
                  type="button"
                  @click.native.prevent="selectNewLogo"
              >
                Select A Logo
              </jet-secondary-button>

              <jet-input-error
                  v-if="form.errors.logo"
                  :message="form.errors.logo"
                  class="mt-2"
              />
            </div>
          </template>
        </monolithic-form-input-card>
        <jet-section-border padding="pb-5 pt-6"/>
        <!-- Game & ModPack -->
        <monolithic-form-input-card>
          <template #label>
            <jet-section-title class="pb-6">
              <template #title>
                Game & ModPack
              </template>
              <template #description>
                Associate your server to a game <required/> & mod-packs
              </template>
            </jet-section-title>
          </template>
          <template #input>
            <!-- Game -->
            <div class="col-span-6 sm:col-span-4">
              <jet-label for="game">
                Game <required/>
              </jet-label>
              <select
                  id="game"
                  v-model="form.game"
                  class="mt-1 block w-full rounded-md shadow-sm form-input"
                  required
              >
                <option
                    :value="null"
                    disabled
                    selected
                >
                  Choose a game
                </option>
                <option
                    v-for="(item, index) in games"
                    :key="index"
                    :value="item.id"
                >
                  {{ item.name }}
                </option>
              </select>
              <jet-input-error
                  v-if="form.errors.game"
                  :message="form.errors.game"
                  class="mt-2"
              />
            </div>
            <!-- ModPack -->
            <div class="col-span-6 sm:col-span-4" v-show="form.game">
              <jet-label
                  for="modPack"
                  value="ModPack"
              />
              <multi-select
                  placeholder="Chose a ModPack"
                  :options-list="availableModPacks"
                  v-model="form.modPacks"
                  :tags="true"
              />
              <jet-input-error
                  v-if="form.errors.modPacks"
                  :message="form.errors.modPacks"
                  class="mt-2"
              />
            </div>
          </template>
        </monolithic-form-input-card>
        <jet-section-border padding="pb-5 pt-6"/>
        <!-- GameQ -->
        <monolithic-form-input-card>
          <template #label>
            <jet-section-title class="pb-6">
              <template #title>
                GameQ
              </template>
              <template #description>
                ip & port
                <required/>
              </template>
            </jet-section-title>
          </template>
          <template #input>
            <!-- IP / HostName -->
            <div class="col-span-6 sm:col-span-4">
              <jet-label
                  for="ip"
                  value="Ip Address / Hostname"
              />
              <jet-input
                  id="ip"
                  v-model="form.ip"
                  type="text"
                  placeholder="My Amazing IP..."
                  class="mt-1 block w-full"
                  autocomplete="ip address"
                  required
              />
              <jet-input-error
                  v-if="form.errors.ip"
                  :message="form.errors.ip"
                  class="mt-2"
              />
            </div>
            <!-- Port -->
            <div class="col-span-6 sm:col-span-4">
              <jet-label
                  for="port"
                  value="Port"
              />
              <jet-input
                  id="port"
                  v-model="form.port"
                  type="number"
                  maxlength="6"
                  placeholder="My Amazing Port..."
                  class="mt-1 block w-full"
                  autocomplete="port"
                  required
              />
              <jet-input-error
                  v-if="form.errors.port"
                  :message="form.errors.port"
                  class="mt-2"
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
          Server Created
        </jet-action-message>
        <jet-button
            class="mr-3"
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
        >
          Save
        </jet-button>
      </template>
    </monolithic-form-section>
  </div>
</template>

<script lang="ts">
import {
  Component, Mixins, Prop, Ref, Watch,
} from 'vue-property-decorator'
import Route from '@/Mixins/Route'

import JetButton from '@/Jetstream/Button.vue'
import JetInput from '@/Jetstream/Input.vue'
import JetInputError from '@/Jetstream/InputError.vue'
import JetLabel from '@/Jetstream/Label.vue'
import JetActionMessage from '@/Jetstream/ActionMessage.vue'
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'
import MonolithicFormSection from '@/Shared/Forms/MonolithicFormSection.vue'
import MdEditor from '@/Shared/Forms/MdEditor.vue'
import JetSectionBorder from '@/Jetstream/SectionBorder.vue'
import Required from '@/Shared/Forms/Required.vue'
import JetSectionTitle from '@/Jetstream/SectionTitle.vue'
import MonolithicFormInputCard from '@/Shared/Forms/MonolithicFormInputCard.vue'
import { MultiSelectOptions } from '@/Shared/Forms/Types/MultiSelectOptions'
import MultiSelect from '@/Shared/Forms/MultiSelect.vue'

@Component({
  components: {
    MonolithicFormInputCard,
    JetActionMessage,
    JetButton,
    MonolithicFormSection,
    JetInput,
    JetInputError,
    JetLabel,
    JetSecondaryButton,
    MdEditor,
    JetSectionBorder,
    Required,
    JetSectionTitle,
    MultiSelect,
  },
})
export default class CreateServerForm extends Mixins(Route) {
  @Prop({ required: true }) readonly modPacks !: Array<any>

  @Prop({ required: true }) readonly games !: Array<any>

  @Ref('logo') readonly logo!: any

  logoPreview: any = null

  form = this.$inertia.form({
    name: null,
    logo: null,
    ip: null,
    port: null,
    game: null,
    modPacks: [],
  })

  availableModPacks: MultiSelectOptions = []

  @Watch('form.game')
  onSelectedGameChanged() {
    this.availableModPacks = this.initAvailableModPacks()
  }

  isModPackLinked(s: any): boolean {
    return !!this.form.modPacks.find((e: any) => e.id === s.id)
  }

  initAvailableModPacks(): MultiSelectOptions {
    const opts: MultiSelectOptions = []
    const filteredModPacks = this.modPacks.filter((mod) => mod.game.id === this.form.game)
    filteredModPacks.forEach((s: any) => {
      opts.push({
        name: s.name,
        value: s.id,
        selected: this.isModPackLinked(s),
      })
    })
    return opts
  }

  selectNewLogo() {
    this.logo.click()
  }

  updateLogoPreview() {
    const reader = new FileReader()

    reader.onload = (e: any) => {
      this.logoPreview = e.target.result
    }

    reader.readAsDataURL(this.logo.files[0])

    this.form.logo = this.logo.files[0]
  }

  submitForm() {
    this.form.port = parseInt(this.form.port, 10)
    this.form.post(this.route('servers.store'),
      {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
          this.logoPreview = null
          this.form.reset()
        },
      })
  }

  created() {
    //
  }
}
</script>
