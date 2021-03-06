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
            <div class="col-span-6 sm:col-span-4" v-if="$page.props.jetstream.managesProfilePhotos">
                <!-- Profile Photo File Input -->
                <input type="file" class="hidden"
                            ref="photo"
                            @change="updatePhotoPreview">

                <jet-label for="photo" value="Photo" />

                <!-- Current Profile Photo -->
                <div class="mt-2" v-show="! photoPreview">
                    <img :src="user.profile_photo_url" alt="Current Profile Photo" class="rounded-full h-20 w-20 object-cover">
                </div>

                <!-- New Profile Photo Preview -->
                <div class="mt-2" v-show="photoPreview">
                    <span class="block rounded-full w-20 h-20"
                          :style="'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + photoPreview + '\');'">
                    </span>
                </div>

                <jet-secondary-button class="mt-2 mr-2" type="button" @click.native.prevent="selectNewPhoto">
                    Select A New Photo
                </jet-secondary-button>

                <jet-secondary-button type="button" class="mt-2" @click.native.prevent="deletePhoto" v-if="user.profile_photo_path">
                    Remove Photo
                </jet-secondary-button>

                <jet-input-error :message="errorMessages.photo" class="mt-2" />
            </div>

            <!-- Name -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="name" value="Name" />
                <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" autocomplete="name" />
                <jet-input-error :message="errorMessages.name" class="mt-2" />
            </div>

            <!-- Email -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="email" value="Email" />
                <jet-input id="email" type="email" class="mt-1 block w-full" v-model="form.email" />
                <jet-input-error :message="errorMessages.email" class="mt-2" />
            </div>
        </template>

        <template #actions>
            <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                Saved.
            </jet-action-message>

            <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
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

    import { Vue, Component, Prop, PropSync, Ref } from 'vue-property-decorator'

    import { objectToFormData } from '@/helpers'

    @Component({
        components: {
            JetActionMessage,
            JetButton,
            JetFormSection,
            JetInput,
            JetInputError,
            JetLabel,
            JetSecondaryButton,
        }
    })
    export default class UpdateProfileInformationForm extends Vue {
        @Ref('photo') readonly photo!: any
        @Prop() readonly user!: any
        @Prop() readonly errors!: any

        photoPreview: any = null

        form: any = {
            name: this.user.name,
            email: this.user.email,
            photo: null,
            recentlySuccessful: false,
            processing: false,
        }

        errorMessages = {
            name: '',
            email: '',
            photo: ''
        }

        updateProfileInformation() {
            this.form.processing = false
            this.form.recentlySuccessful = false

            if (this.photo.files[0]) {
                this.form.photo = this.photo.files[0]
            }

            // @ts-ignore
            this.$inertia.post(
                // @ts-ignore
                route('user-profile-information.update'),
                objectToFormData(this.form, 'PUT'),
                {
                    preserveScroll: true,
                    resetOnSuccess: false,
                    onSuccess: () => {
                        this.form.processing = false
                        if (!this.errors.updateProfileInformation) {
                            this.photoPreview = null
                            this.form.recentlySuccessful = true
                        } else {
                            this.errorMessages = this.errors.updateProfileInformation
                        }
                    }
                }
            )
        }

        selectNewPhoto() {
            this.photo.click();
        }

        updatePhotoPreview() {
            const reader = new FileReader()

            reader.onload = (e: any) => {
                this.photoPreview = e.target.result
            };

            reader.readAsDataURL(this.photo.files[0])
        }

        deletePhoto() {
            // @ts-ignore
            this.$inertia.delete(
                // @ts-ignore
                route('current-user-photo.destroy'),
                {
                    preserveScroll: true,
                    onSuccess: () => {
                        this.photoPreview = null
                        this.form.photo = null
                    }
                }
            )
        }
    }

    /*
    export default {

        methods: {
            updateProfileInformation() {
                if (this.$refs.photo) {
                    this.form.photo = this.$refs.photo.files[0]
                }

                this.form.post(route('user-profile-information.update'), {
                    preserveScroll: true
                });
            },

            selectNewPhoto() {
                this.$refs.photo.click();
            },

            updatePhotoPreview() {
                const reader = new FileReader();

                reader.onload = (e) => {
                    this.photoPreview = e.target.result;
                };

                reader.readAsDataURL(this.$refs.photo.files[0]);
            },

            deletePhoto() {
                this.$inertia.delete(route('current-user-photo.destroy'), {
                    preserveScroll: true,
                }).then(() => {
                    this.photoPreview = null
                });
            },
        },
    }*/
</script>
