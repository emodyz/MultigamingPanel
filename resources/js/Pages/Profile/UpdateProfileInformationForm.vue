<template>
  <jet-form-section @submitted="updateProfileInformation">
    <template #title>
      Profile Information
    </template>

    <template #description>
      Update your account's profile information and email address.
    </template>

    <template #form>
      <!-- Profile Photo -->
      <div
          v-if="$page.props.jetstream.managesProfilePhotos"
          class="col-span-6 sm:col-span-4"
      >
        <!-- Profile Photo File Input -->
        <input
            ref="photo"
            type="file"
            class="hidden"
            @change="updatePhotoPreview"
        >

        <jet-label
            for="photo"
            value="Photo"
        />

        <!-- Current Profile Photo -->
        <div
            v-show="! photoPreview"
            class="mt-2"
        >
          <img
              :src="user.profile_photo_url"
              alt="Current Profile Photo"
              class="rounded-full h-20 w-20 object-cover"
          >
        </div>

        <!-- New Profile Photo Preview -->
        <div
            v-show="photoPreview"
            class="mt-2"
        >
          <span
              class="block rounded-full w-20 h-20"
              :style="'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + photoPreview + '\');'"
          />
        </div>

        <jet-secondary-button
            class="mt-2 mr-2"
            type="button"
            @click.native.prevent="selectNewPhoto"
        >
          Select A New Photo
        </jet-secondary-button>

        <jet-secondary-button
            v-if="user.profile_photo_path"
            type="button"
            class="mt-2"
            @click.native.prevent="deletePhoto"
        >
          Remove Photo
        </jet-secondary-button>

        <jet-input-error
            v-if="form.errors.photo"
            :message="form.errors.photo"
            class="mt-2"
        />
      </div>

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
            class="mt-1 block w-full"
            autocomplete="name"
        />
        <jet-input-error
            v-if="form.errors.name"
            :message="form.errors.name"
            class="mt-2"
        />
      </div>

      <!-- Email -->
      <div class="col-span-6 sm:col-span-4">
        <jet-label
            for="email"
            value="Email"
        />
        <jet-input
            id="email"
            v-model="form.email"
            type="email"
            class="mt-1 block w-full"
        />
        <jet-input-error
            v-if="form.errors.email"
            :message="form.errors.email"
            class="mt-2"
        />
      </div>
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
  </jet-form-section>
</template>

<script lang="ts">
import JetButton from '@/Jetstream/Button.vue'
import JetFormSection from '@/Jetstream/FormSection.vue'
import JetInput from '@/Jetstream/Input.vue'
import JetInputError from '@/Jetstream/InputError.vue'
import JetLabel from '@/Jetstream/Label.vue'
import JetActionMessage from '@/Jetstream/ActionMessage.vue'
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'

import {
  Mixins, Component, Prop, Ref,
} from 'vue-property-decorator'

import Route from '@/Mixins/Route'

@Component({
  components: {
    JetActionMessage,
    JetButton,
    JetFormSection,
    JetInput,
    JetInputError,
    JetLabel,
    JetSecondaryButton,
  },
})
export default class UpdateProfileInformationForm extends Mixins(Route) {
  @Ref('photo') readonly photo!: any

  @Prop() readonly user!: any

  @Prop() readonly errors!: any

  photoPreview: any = null

  form = this.$inertia.form({
    _method: 'PUT',
    name: this.user.name,
    email: this.user.email,
    photo: null,
  })

  updateProfileInformation() {
    this.form.processing = false
    this.form.recentlySuccessful = false

    if (this.photo.files[0]) {
      this.form.photo = this.photo.files[0]
    }

    this.form.post(this.route('user-profile-information.update'), {
      preserveScroll: true,
      preserveState: true,
      errorBag: 'updateProfileInformation',
      onSuccess: () => {
        this.resetPhotoInput()
      },
    })
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
      this.route('current-user-photo.destroy'),
      {
        preserveScroll: true,
        onSuccess: () => {
          this.resetPhotoInput()
        },
      },
    )
  }

  resetPhotoInput() {
    this.photoPreview = null
    this.form.photo = null
    this.photo.files = null
  }
}
</script>
