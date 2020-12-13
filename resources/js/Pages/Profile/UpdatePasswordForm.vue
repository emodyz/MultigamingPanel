<template>
    <jet-form-section @submitted="updatePassword">
        <template #title>
            Update Password
        </template>

        <template #description>
            Ensure your account is using a long, random password to stay secure.
        </template>

        <template #form>
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="current_password" value="Current Password" />
                <jet-input id="current_password" type="password" class="mt-1 block w-full" v-model="form.current_password" ref="current_password" autocomplete="current-password" />
                <jet-input-error :message="errorMessages.current_password" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <jet-label for="password" value="New Password" />
                <jet-input id="password" type="password" class="mt-1 block w-full" v-model="form.password" autocomplete="new-password" />
                <jet-input-error v-if="!form.recentlySuccessful" :message="errorMessages.password" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <jet-label for="password_confirmation" value="Confirm Password" />
                <jet-input id="password_confirmation" type="password" class="mt-1 block w-full" v-model="form.password_confirmation" autocomplete="new-password" />
                <jet-input-error v-if="!form.recentlySuccessful" :message="errorMessages.password_confirmation" class="mt-2" />
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
    import JetActionMessage from '@/Jetstream/ActionMessage.vue'
    import JetButton from '@/Jetstream/Button.vue'
    import JetFormSection from '@/Jetstream/FormSection.vue'
    import JetInput from '@/Jetstream/Input.vue'
    import JetInputError from '@/Jetstream/InputError.vue'
    import JetLabel from '@/Jetstream/Label.vue'

    import { Vue, Component, Prop, PropSync, Ref } from 'vue-property-decorator'

    @Component({
        components: {
            JetActionMessage,
            JetButton,
            JetFormSection,
            JetInput,
            JetInputError,
            JetLabel,
        }
    })
    export default class UpdatePasswordForm extends Vue {
        @Ref('current_password') readonly current_password!: any

        errorMessages = {
            password: '',
            password_confirmation: '',
            current_password: ''
        }

        form = {
            password: '',
            password_confirmation: '',
            current_password: '',
            recentlySuccessful: false,
            processing: false,
        }

        updatePassword() {
            this.form.processing = true
            this.form.recentlySuccessful = false
            // @ts-ignore
            this.$inertia.put(
                // @ts-ignore
                route('user-password.update'),
                this.form,
                {
                    preserveScroll: true,
                    onSuccess: () => {
                        this.form.processing = false
                        // @ts-ignore
                        if (!this.$page.props.errors.updatePassword) {
                            this.errorMessages = {
                                password: '',
                                password_confirmation: '',
                                current_password: ''
                            }
                            this.form.recentlySuccessful = true
                        } else {
                            // @ts-ignore
                            this.errorMessages = this.$page.props.errors.updatePassword
                            this.current_password.focus()
                        }
                    }
                }
            )
        }
    }
</script>
