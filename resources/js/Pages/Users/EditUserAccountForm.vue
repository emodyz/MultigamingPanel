<template>
    <jet-form-section @submitted="editUserAccount">
        <template #title>
            Account Information
        </template>

        <template #description>
            Edit {{ user.name }}'s account information.
        </template>

        <template #form>
            <!-- Email -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="email" value="Email" />
                <jet-input id="email" type="email" class="mt-1 block w-full" v-model="form.email" />
                <jet-input-error :message="errorMessages.email" class="mt-2" />
            </div>

            <!-- Role -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="role" value="Role" />
                <select v-model="form.role" class="mt-1 block w-full rounded-md shadow-sm form-input" name="role" id="role">
                    <option value="" disabled selected>Choose a role</option>
                    <option v-for="(item, index) in roles" :value="index">{{ item.displayName }}</option>
                </select>
                <jet-input-error :message="errorMessages.role" class="mt-2" />
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

import { Vue, Component, Prop } from 'vue-property-decorator'

import {User} from "@/Shared/DataTable/Types/User";

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
export default class EditUserProfileForm extends Vue {
    @Prop() readonly user!: User
    @Prop() readonly roles!: any
    @Prop() readonly errors!: any

    form: any = {
        email: this.user.email,
        role: this.user.role,
        recentlySuccessful: false,
        processing: false,
    }

    errorMessages = {
        email: '',
        role: '',
        photo: ''
    }

    editUserAccount() {
        this.form.processing = false
        this.form.recentlySuccessful = false

        // @ts-ignore
        this.$inertia.put(
            // @ts-ignore
            route('users.update.account', this.user.id),
            this.form,
            {
                preserveScroll: true,
                resetOnSuccess: false,
                onSuccess: () => {
                    this.form.processing = false
                    if (!this.errors.editUserAccount) {
                        this.form.recentlySuccessful = true
                    } else {
                        this.errorMessages = this.errors.editUserAccount
                    }
                }
            }
        )
    }
}
</script>
