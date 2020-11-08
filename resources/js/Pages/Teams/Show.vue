<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Team Settings
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <update-team-name-form :errors="errors" :team="team" :permissions="permissions" />

                <team-member-manager class="mt-10 sm:mt-0"
                            :team="team"
                            :available-roles="availableRoles"
                            :user-permissions="permissions"
                            :errors="errors" />

                <template v-if="permissions.canDeleteTeam && ! team.personal_team">
                    <jet-section-border />

                    <delete-team-form class="mt-10 sm:mt-0" :team="team" :errors="errors" />
                </template>
            </div>
        </div>
    </app-layout>
</template>

<script lang="ts">
    import TeamMemberManager from './TeamMemberManager.vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import DeleteTeamForm from './DeleteTeamForm.vue'
    import JetSectionBorder from '@/Jetstream/SectionBorder.vue'
    import UpdateTeamNameForm from './UpdateTeamNameForm.vue'

    import { Vue, Component, Prop } from 'vue-property-decorator'

    @Component({
        components: {
            AppLayout,
            DeleteTeamForm,
            JetSectionBorder,
            TeamMemberManager,
            UpdateTeamNameForm,
        }
    })
    export default class TeamShow extends Vue {
        @Prop() team!: any
        @Prop() availableRoles!: any
        @Prop() permissions!: any
        @Prop() errors!: any
    }
</script>
