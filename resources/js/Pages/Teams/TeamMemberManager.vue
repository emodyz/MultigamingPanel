<template>
    <div>
        <div v-if="userPermissions.canAddTeamMembers">
            <jet-section-border />

            <!-- Add Team Member -->
            <jet-form-section @submitted="addTeamMember">
                <template #title>
                    Add Team Member
                </template>

                <template #description>
                    Add a new team member to your team, allowing them to collaborate with you.
                </template>

                <template #form>
                    <div class="col-span-6">
                        <div class="max-w-xl text-sm text-gray-600">
                            Please provide the email address of the person you would like to add to this team. The email address must be associated with an existing account.
                        </div>
                    </div>

                    <!-- Member Email -->
                    <div class="col-span-6 sm:col-span-4">
                        <jet-label for="email" value="Email" />
                        <jet-input id="email" type="text" class="mt-1 block w-full" v-model="addTeamMemberForm.email" />
                        <jet-input-error :message="addTeamMemberForm.errors.email" class="mt-2" />
                    </div>

                    <!-- Role -->
                    <div class="col-span-6 lg:col-span-4" v-if="availableRoles.length > 0">
                        <jet-label for="roles" value="Role" />
                        <jet-input-error :message="addTeamMemberForm.errors.role" class="mt-2" />

                        <div class="mt-1 border border-gray-200 rounded-lg cursor-pointer">
                            <div class="px-4 py-3"
                                            :class="{'border-t border-gray-200': i > 0}"
                                            @click="addTeamMemberForm.role = role.key"
                                            v-for="(role, i) in availableRoles"
                                            :key="role.key"
                                            >
                                <div :class="{'opacity-50': addTeamMemberForm.role && addTeamMemberForm.role != role.key}">
                                    <!-- Role Name -->
                                    <div class="flex items-center">
                                        <div class="text-sm text-gray-600" :class="{'font-semibold': addTeamMemberForm.role == role.key}">
                                            {{ role.name }}
                                        </div>

                                        <svg v-if="addTeamMemberForm.role == role.key" class="ml-2 h-5 w-5 text-green-400" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>

                                    <!-- Role Description -->
                                    <div class="mt-2 text-xs text-gray-600">
                                        {{ role.description }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>

                <template #actions>
                    <jet-action-message :on="addTeamMemberForm.recentlySuccessful" class="mr-3">
                        Added.
                    </jet-action-message>

                    <jet-button :class="{ 'opacity-25': addTeamMemberForm.processing }" :disabled="addTeamMemberForm.processing">
                        Add
                    </jet-button>
                </template>
            </jet-form-section>
        </div>

        <div v-if="team.users.length > 0">
            <jet-section-border />

            <!-- Manage Team Members -->
            <jet-action-section class="mt-10 sm:mt-0">
                <template #title>
                    Team Members
                </template>

                <template #description>
                    All of the people that are part of this team.
                </template>

                <!-- Team Member List -->
                <template #content>
                    <div class="space-y-6">
                        <div class="flex items-center justify-between" v-for="user in team.users" :key="user.id">
                            <div class="flex items-center">
                                <img class="w-8 h-8 rounded-full" :src="user.profile_photo_url" :alt="user.name">
                                <div class="ml-4">{{ user.name }}</div>
                            </div>

                            <div class="flex items-center">
                                <!-- Manage Team Member Role -->
                                <button class="ml-2 text-sm text-gray-400 underline"
                                        v-if="userPermissions.canAddTeamMembers && availableRoles.length"
                                        @click="manageRole(user)">
                                    {{ displayableRole(user.membership.role) }}
                                </button>

                                <div class="ml-2 text-sm text-gray-400" v-else-if="availableRoles.length">
                                    {{ displayableRole(user.membership.role) }}
                                </div>

                                <!-- Leave Team -->
                                <button class="cursor-pointer ml-6 text-sm text-red-500 focus:outline-none"
                                                    @click="confirmLeavingTeam"
                                                    v-if="$page.props.user.id === user.id">
                                    Leave
                                </button>

                                <!-- Remove Team Member -->
                                <button class="cursor-pointer ml-6 text-sm text-red-500 focus:outline-none"
                                                    @click="confirmTeamMemberRemoval(user)"
                                                    v-if="userPermissions.canRemoveTeamMembers">
                                    Remove
                                </button>
                            </div>
                        </div>
                    </div>
                </template>
            </jet-action-section>
        </div>

        <!-- Role Management Modal -->
        <jet-dialog-modal :show="currentlyManagingRole" @close="currentlyManagingRole = false">
            <template #title>
                Manage Role
            </template>

            <template #content>
                <div v-if="managingRoleFor">
                    <div class="mt-1 border border-gray-200 rounded-lg cursor-pointer">
                        <div class="px-4 py-3"
                                        :class="{'border-t border-gray-200': i > 0}"
                                        @click="updateRoleForm.role = role.key"
                                        v-for="(role, i) in availableRoles"
                                        :key="role.key"
                                        >
                            <div :class="{'opacity-50': updateRoleForm.role && updateRoleForm.role != role.key}">
                                <!-- Role Name -->
                                <div class="flex items-center">
                                    <div class="text-sm text-gray-600" :class="{'font-semibold': updateRoleForm.role == role.key}">
                                        {{ role.name }}
                                    </div>

                                    <svg v-if="updateRoleForm.role == role.key" class="ml-2 h-5 w-5 text-green-400" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>

                                <!-- Role Description -->
                                <div class="mt-2 text-xs text-gray-600">
                                    {{ role.description }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </template>

            <template #footer>
                <jet-secondary-button @click.native="currentlyManagingRole = false">
                    Nevermind
                </jet-secondary-button>

                <jet-button class="ml-2" @click.native="updateRole" :class="{ 'opacity-25': updateRoleForm.processing }" :disabled="updateRoleForm.processing">
                    Save
                </jet-button>
            </template>
        </jet-dialog-modal>

        <!-- Leave Team Confirmation Modal -->
        <jet-confirmation-modal :show="confirmingLeavingTeam" @close="confirmingLeavingTeam = false">
            <template #title>
                Leave Team
            </template>

            <template #content>
                Are you sure you would like to leave this team?
            </template>

            <template #footer>
                <jet-secondary-button @click.native="confirmingLeavingTeam = false">
                    Nevermind
                </jet-secondary-button>

                <jet-danger-button class="ml-2" @click.native="leaveTeam" :class="{ 'opacity-25': leaveTeamForm.processing }" :disabled="leaveTeamForm.processing">
                    Leave
                </jet-danger-button>
            </template>
        </jet-confirmation-modal>

        <!-- Remove Team Member Confirmation Modal -->
        <jet-confirmation-modal :show="teamMemberBeingRemoved" @close="teamMemberBeingRemoved = null">
            <template #title>
                Remove Team Member
            </template>

            <template #content>
                Are you sure you would like to remove this person from the team?
            </template>

            <template #footer>
                <jet-secondary-button @click.native="teamMemberBeingRemoved = null">
                    Nevermind
                </jet-secondary-button>

                <jet-danger-button class="ml-2" @click.native="removeTeamMember" :class="{ 'opacity-25': removeTeamMemberForm.processing }" :disabled="removeTeamMemberForm.processing">
                    Remove
                </jet-danger-button>
            </template>
        </jet-confirmation-modal>
    </div>
</template>

<script lang="ts">
    import JetActionMessage from '@/Jetstream/ActionMessage.vue'
    import JetActionSection from '@/Jetstream/ActionSection.vue'
    import JetButton from '@/Jetstream/Button.vue'
    import JetConfirmationModal from '@/Jetstream/ConfirmationModal.vue'
    import JetDangerButton from '@/Jetstream/DangerButton.vue'
    import JetDialogModal from '@/Jetstream/DialogModal.vue'
    import JetFormSection from '@/Jetstream/FormSection.vue'
    import JetInput from '@/Jetstream/Input.vue'
    import JetInputError from '@/Jetstream/InputError.vue'
    import JetLabel from '@/Jetstream/Label.vue'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'
    import JetSectionBorder from '@/Jetstream/SectionBorder.vue'

    import { Vue, Component, Prop } from 'vue-property-decorator'

    @Component({
        components: {
            JetActionMessage,
            JetActionSection,
            JetButton,
            JetConfirmationModal,
            JetDangerButton,
            JetDialogModal,
            JetFormSection,
            JetInput,
            JetInputError,
            JetLabel,
            JetSecondaryButton,
            JetSectionBorder,
        }
    })
    export default class TeamMemberManager extends Vue {
        @Prop() team!: any
        @Prop() availableRoles!: any
        @Prop() userPermissions!: any
        @Prop() errors!: any

        addTeamMemberFormTemplate: any = {
            email:  '',
            role: null,
            processing: false,
            errors: {
                email: '',
                role: ''
            },
            recentlySuccessful: false
        }
        addTeamMemberForm: any = this.addTeamMemberFormTemplate

        updateRoleForm: any = {
            role: null,
            processing: false,
            errors: {
                role: ''
            }
        }

        leaveTeamForm: any = {
            processing: false,
            errors: null,
        }

        removeTeamMemberForm: any = {
            processing: false,
            errors: null,
        }

        currentlyManagingRole: any = false
        managingRoleFor: any =  null
        confirmingLeavingTeam: any =  false
        teamMemberBeingRemoved: any =  null

        addTeamMember() {
            this.addTeamMemberForm.processing = true
            this.addTeamMemberForm.recentlySuccessful = false
            // @ts-ignore
            this.$inertia.post(
                // @ts-ignore
                route('team-members.store', this.team),
                this.addTeamMemberForm,
                {
                    preserveScroll: true,
                    onSuccess: () => {
                        this.addTeamMemberForm.processing = false
                        this.addTeamMemberForm.recentlySuccessfulg = false
                        if (this.addTeamMemberForm.errors.addTeamMember) {
                            this.addTeamMemberForm.errors = this.addTeamMemberForm.errors.addTeamMember
                        }
                    }
                }
            )
        }

        manageRole(teamMember: any) {
            this.managingRoleFor = teamMember
            this.updateRoleForm.role = teamMember.membership.role
            this.currentlyManagingRole = true
        }

        updateRole() {
            this.updateRoleForm.processing = true
            // @ts-ignore
            this.$inertia.put(
                // @ts-ignore
                route('team-members.update', [this.team, this.managingRoleFor]),
                this.updateRoleForm,
                {
                    preserveScroll: true,
                    onSuccess: () => {
                        this.updateRoleForm.processing = false
                        this.currentlyManagingRole = false
                        if (this.updateRoleForm.errors.updateRole) {
                            this.updateRoleForm.errors = this.updateRoleForm.errors.updateRole
                        }
                    }
                }
            )
        }

        confirmLeavingTeam() {
            this.confirmingLeavingTeam = true
        }

        leaveTeam() {
            this.leaveTeamForm.processing = true
            // @ts-ignore
            this.$inertia.delete(route('team-members.destroy', [this.team, this.$page.props.user]), { onSuccess: () => { this.leaveTeamForm.processing = false } })
        }

        confirmTeamMemberRemoval(teamMember: any) {
            this.teamMemberBeingRemoved = teamMember
        }

        removeTeamMember() {
            // @ts-ignore
            this.$inertia.delete(
                // @ts-ignore
                route('team-members.destroy', [this.team, this.teamMemberBeingRemoved]),
                {
                    onSuccess: () => {
                        this.removeTeamMemberForm.processing = false
                        this.teamMemberBeingRemoved = null
                    }
                })
        }

        displayableRole(role: any) {
            return this.availableRoles.find((r: any) => r.key == role).name
        }
    }
</script>
