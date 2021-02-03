<template>
  <app-layout>
    <template #header>
      <h2 class="breadcrumb">
        Create Team
      </h2>
    </template>

    <div>
      <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <create-team-form />
      </div>
    </div>
  </app-layout>
</template>

<script lang="ts">
import AppLayout from '@/Layouts/AppLayout.vue'
import JetSectionBorder from '@/Jetstream/SectionBorder.vue'

import { Vue, Component, Prop } from 'vue-property-decorator'
import CreateTeamForm from './CreateTeamForm.vue'

    @Component({
      components: {
        AppLayout,
        CreateTeamForm,
        JetSectionBorder,
      },
    })
export default class TeamCreate extends Vue {
        @Prop() team!: any
}
</script>
