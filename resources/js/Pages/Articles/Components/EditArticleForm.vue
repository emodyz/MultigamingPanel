<template>
  <div>
    <monolithic-form-section @submitted="submitForm">
      <template #title>
        Edit this article
      </template>

      <template #description>
        Edit the title
        <required/>
        and subtitle (optional) to of this article.
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
        <!-- Article Cover Image -->
        <monolithic-form-input-card>
          <template #label>
            <jet-section-title class="pb-6">
              <template #title>
                Cover Image
              </template>
              <template #description>
                Change the cover image illustrating this article
                <required/>
              </template>
            </jet-section-title>
          </template>
          <template #input>
            <!-- TODO: Extract image input into a component and implement v-model -->
            <div class="col-span-6">
              <!-- Cover Image File Input -->
              <input
                  ref="cover"
                  type="file"
                  class="hidden"
                  @change="updateCoverPreview"
              >
              <!-- Cover Image Preview -->
              <div
                  v-show="coverPreview"
                  class="mb-6"
              >
                <img class="border border-zinc-300 dark:border-zinc-700 rounded-xl shadow-lg max-h-96" :src="coverPreview"
                     alt="Cover Image">
              </div>

              <jet-secondary-button
                  type="button"
                  @click.native.prevent="selectNewCover"
              >
                Select A Cover Image
              </jet-secondary-button>

              <jet-input-error
                  v-if="form.errors.coverImage"
                  :message="form.errors.coverImage"
                  class="mt-2"
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
        <jet-input-error
            v-if="form.errors.content"
            :message="form.errors.content"
            class="mt-2"
        />
        <md-editor v-model="form.content"/>
      </template>

      <template #actions>
        <!-- TODO: Add a status indicator. ie. BADGES: Draft Or Published -->

        <jet-action-message
            :on="form.recentlySuccessful"
            class="mr-3"
        >
          {{ formSuccessMsg }}
        </jet-action-message>

        <jet-secondary-button
            type="submit"
            class="mr-3"
            @click.native="handleDraft"
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
        >
          Save as draft
        </jet-secondary-button>

        <jet-button
            type="button"
            @click.native="handlePublish"
            class="mr-3"
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
        >
          Publish
        </jet-button>
      </template>
    </monolithic-form-section>
  </div>
</template>

<script lang="ts">
import {
  Component, Prop, Ref, Mixins,
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
import MultiSelect from '@/Shared/Forms/MultiSelect.vue'
import { MultiSelectOptions } from '@/Shared/Forms/Types/MultiSelectOptions'
import MonolithicFormInputCard from '@/Shared/Forms/MonolithicFormInputCard.vue'
import MultiSelectServerRow from '@/Shared/Forms/MultiSelectServerRow.vue'
import { Article } from '@/Shared/DataTable/Types/Article'

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
export default class EditArticleForm extends Mixins(Route) {
  @Prop() readonly servers !: Array<any>

  @Prop() readonly article !: Article

  @Ref('cover') readonly cover!: any

  // TODO: Save & load content from localStorage until a from is submitted

  serversOptions: MultiSelectOptions = this.initServerOptions()

  coverPreview: any = this.article.cover_image_url

  form = this.$inertia.form({
    _method: 'PUT',
    title: this.article.title,
    subTitle: this.article.subTitle,
    coverImage: null,
    servers: this.getLinkedServersIds(),
    content: this.article.content,
    status: this.article.status,
  })

  formSuccessMsg = 'This draft has been edited!'

  getLinkedServersIds() {
    const lsids: any[] = []
    this.article.servers.forEach((s: any) => {
      lsids.push(s.id)
    })
    return lsids
  }

  isServerLinked(s: any): boolean {
    return !!this.article.servers.find((e: any) => e.id === s.id)
  }

  initServerOptions(): MultiSelectOptions {
    const opts: MultiSelectOptions = []
    this.servers.forEach((s: any) => {
      opts.push({
        name: s.name,
        value: s.id,
        selected: this.isServerLinked(s),
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

  selectNewCover() {
    this.cover.click()
  }

  updateCoverPreview() {
    const reader = new FileReader()

    reader.onload = (e: any) => {
      this.coverPreview = e.target.result
    }

    reader.readAsDataURL(this.cover.files[0])

    this.form.coverImage = this.cover.files[0]
  }

  submitForm() {
    this.form.post(
      this.route('articles.update', this.article.id),
      {
        preserveScroll: true,
        preserveState: true,
        onSuccess: (page: any) => {
          this.coverPreview = page.props.article.cover_image_url
          this.form.coverImage = null
        },
      },
    )
  }

  handlePublish() {
    this.formSuccessMsg = 'This article has been edited and published'
    this.form.status = 'published'
    this.submitForm()
  }

  handleDraft() {
    this.formSuccessMsg = 'This draft has been edited!'
    this.form.status = 'draft'
    this.submitForm()
  }

  created() {
    //
  }
}
</script>
