<template>
  <div>
    <monolithic-form-section @submitted="form.post(route('articles.store'))">
      <template #title>
        Write a new article
      </template>

      <template #description>
        Add a title
        <required/>
        and a subtitle (optional) to your new article.
      </template>

      <template #form>
        <!-- Title -->
        <div class="col-span-6 sm:col-span-4">
          <jet-label
              for="title"
              value="Title"
          />
          <jet-input
              id="title"
              v-model="form.title"
              required
              type="text"
              maxlength="80"
              placeholder="My Amazing Title..."
              class="mt-1 block w-full"
              autocomplete="title"
          />
          <jet-input-error
              v-if="form.errors.title"
              :message="form.errors.title"
              class="mt-2"
          />
        </div>
        <!-- Title -->
        <div class="col-span-6">
          <jet-label
              for="subTitle"
              value="Subtitle"
          />
          <jet-input
              id="subTitle"
              v-model="form.subTitle"
              type="text"
              maxlength="256"
              placeholder="My Optional Subtitle..."
              class="mt-1 block w-full"
              autocomplete="subtitle"
          />
          <jet-input-error
              v-if="form.errors.subTitle"
              :message="form.errors.subTitle"
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
                You can chose to link this article to one or more servers
              </template>
            </jet-section-title>
          </template>

          <template #input>
            <div class="col-span-6 sm:col-span-4">
              <multi-select
                  placeholder="Chose a server"
                  :options-list="serversOptions"
                  v-model="form.servers"
                  :tags="true"
              />
            </div>
          </template>
        </monolithic-form-input-card>
        <jet-section-border padding="pb-5 pt-6"/>
        <!-- Content MD -->
        <jet-section-title class="pb-5">
          <template #title>
            Add some content
          </template>
          <template #description>
            Markdown ftw!
            <required/>
          </template>
        </jet-section-title>
        <md-editor v-model="form.content"/>
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
    </monolithic-form-section>
  </div>
</template>

<script lang="ts">
import {
  Component, /* Prop, Ref, */ Mixins, Prop,
} from 'vue-property-decorator'
// import { objectToFormData } from '@/Shared/Helpers/objectToFormData'
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
import MultiSelect from '@/Shared/Forms/MultiSelect.vue'
import { MultiSelectOptions } from '@/Shared/Forms/Types/MultiSelectOptions'
import MonolithicFormInputCard from '@/Shared/Forms/MonolithicFormInputCard.vue'
import MultiSelectServerRow from '@/Shared/Forms/MultiSelectServerRow.vue'

@Component({
  components: {
    MonolithicFormInputCard,
    MultiSelect,
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
  },
})
export default class CreateArticleForm extends Mixins(Route) {
  @Prop() readonly servers !: Array<any>

  form = this.$inertia.form({
    title: null,
    subTitle: null,
    servers: null,
    content: null,
  })

  serversOptions: MultiSelectOptions = this.initServerOptions()

  initServerOptions(): MultiSelectOptions {
    const opts: MultiSelectOptions = []
    this.servers.forEach((s: any) => {
      opts.push({
        name: s.name,
        value: s.id,
        component: {
          instance: MultiSelectServerRow,
          properties: {
            logo: s.logo_url,
            game: {
              name: s.game.name,
              logo: s.game.logo_url,
              identifier: s.game.identifier,
            },
          },
        },
      })
    })
    return opts
  }

  created() {
    /**
     * TODO: Add the ability to pass custom html to the multiselect so that i can customize rows ie. server logo and game badge.
     * */
    console.log(this.servers)
  }

  /*
  photoPreview: any = null

  form: any = {
    name: this.user.name,
    photo: null,
    recentlySuccessful: false,
    processing: false,
  }

  errorMessages = {
    name: '',
    photo: '',
  }

  editUserProfile() {
    this.form.processing = false
    this.form.recentlySuccessful = false

    if (this.photo.files[0]) {
      this.form.photo = this.photo.files[0]
    }

    this.$inertia.post(
      this.route('users.update', this.user.id),
      objectToFormData(this.form, 'PUT'),
      {
        preserveScroll: true,
        resetOnSuccess: false,
        onSuccess: (page: any) => {
          this.form.processing = false
          if (!page.props.errors.editUserProfile) {
            this.photoPreview = null
            this.form.recentlySuccessful = true
          } else {
            this.errorMessages = page.props.errors.editUserProfile
          }
        },
      },
    )
  }

  selectNewPhoto() {
    this.photo.click()
  }

  updatePhotoPreview() {
    const reader = new FileReader()

    reader.onload = (e: any) => {
      this.photoPreview = e.target.result
    }

    reader.readAsDataURL(this.photo.files[0])
  }

  deletePhoto() {
    this.$inertia.delete(
      this.route('users.destroy.avatar', this.user),
      {
        preserveScroll: true,
        onSuccess: () => {
          this.photoPreview = null
          this.form.photo = null
        },
      },
    )
  }
  */
}
</script>
