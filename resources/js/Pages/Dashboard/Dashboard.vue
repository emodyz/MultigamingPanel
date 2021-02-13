<template>
    <app-layout>
        <template #header>
            <h2 class="breadcrumb">
                Dashboard
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                  <users-chart :stats="usersStats"/>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script lang="ts">
import {
  Vue, Component, Prop,
} from 'vue-property-decorator'

import AppLayout from '@/Layouts/AppLayout.vue'
import Welcome from '@/Jetstream/Welcome.vue'
import UsersChart from '@/Pages/Dashboard/Components/UsersChart.vue'

@Component({
  components: {
    AppLayout,
    Welcome,
    UsersChart,
  },
})
export default class Dashboard extends Vue {
  @Prop() usersStats !: any
}
</script>
