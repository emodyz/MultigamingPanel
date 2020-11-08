<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create Team
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <create-team-form :errors="errors" />
            </div>
        </div>
    </app-layout>
</template>

<script lang="ts">
    import AppLayout from '@/Layouts/AppLayout'
    import CreateTeamForm from './CreateTeamForm.vue'
    import JetSectionBorder from '@/Jetstream/SectionBorder'

    import { Vue, Component, Prop } from 'vue-property-decorator'

    @Component({
        components: {
            AppLayout,
            CreateTeamForm,
            JetSectionBorder,
        }
    })
    export default class TeamCreate extends Vue {
        @Prop() team!: any
        @Prop() errors!: any
    }
</script>
