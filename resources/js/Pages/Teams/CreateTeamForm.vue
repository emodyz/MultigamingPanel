<template>
    <jet-form-section @submitted="createTeam">
        <template #title>
            Team Details
        </template>

        <template #description>
            Create a new team to collaborate with others on projects.
        </template>

        <template #form>
            <div class="col-span-6">
                <jet-label value="Team Owner" />

                <div class="flex items-center mt-2">
                    <img class="w-12 h-12 rounded-full object-cover" :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name">

                    <div class="ml-4 leading-tight">
                        <div>{{ $page.props.user.name }}</div>
                        <div class="text-gray-700 text-sm">{{ $page.props.user.email }}</div>
                    </div>
                </div>
            </div>

            <div class="col-span-6 sm:col-span-4">
                <jet-label for="name" value="Team Name" />
                <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" autofocus />
                <jet-input-error :message="form.errors.name" class="mt-2" />
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

    import { Vue, Component, Prop } from 'vue-property-decorator'

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
    export default class CreateTeamForm extends Vue {
        @Prop() readonly errors!: any

        form: any = {
            name:  '',
            processing: false,
            recentlySuccessful: false,
            errors: {
                name: ''
            }
        }

        createTeam() {
            this.form.processing = true
            this.form.recentlySuccessful = false
            // @ts-ignore
            this.$inertia.post(
                // @ts-ignore
                route('teams.store'),
                this.form,
                {
                    preserveScroll: true,
                    onSuccess: () => {
                        this.form.processing = false
                        this.form.recentlySuccessfulg = false
                        if (this.form.errors.createTeam) {
                            this.form.errors = this.form.errors.createTeam
                        }
                    }
                }
            )
        }
    }
</script>
