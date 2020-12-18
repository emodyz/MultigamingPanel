<template>
  <jet-form-section @submitted="editUserProfile">
    <template #title>
      Profile Information
    </template>

    <template #description>
      Edit {{ user.name }}'s profile information.
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
          v-if="!form.recentlySuccessful"
          :message="errorMessages.photo"
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
          v-if="!form.recentlySuccessful"
          :message="errorMessages.name"
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
  Vue, Component, Prop, Ref,
} from 'vue-property-decorator'

import { objectToFormData } from '@/Shared/Helpers/objectToFormData.ts'
import { User } from '@/Shared/DataTable/Types/User.d.ts'

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
export default class EditUserProfileForm extends Vue {
    @Ref('photo') readonly photo!: any

    @Prop() readonly user!: User

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

      // @ts-ignore
      this.$inertia.post(
        // @ts-ignore
        route('users.update', this.user.id),
        objectToFormData(this.form, 'PUT'),
        {
          preserveScroll: true,
          resetOnSuccess: false,
          onSuccess: () => {
            this.form.processing = false
            // @ts-ignore
            if (!this.$page.props.errors.editUserProfile) {
              this.photoPreview = null
              this.form.recentlySuccessful = true
            } else {
              // @ts-ignore
              this.errorMessages = this.$page.props.errors.editUserProfile
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
      // @ts-ignore
      this.$inertia.delete(
        // @ts-ignore
        route('users.destroy.avatar', this.user),
        {
          preserveScroll: true,
          onSuccess: () => {
            this.photoPreview = null
            this.form.photo = null
          },
        },
      )
    }
}
</script>
