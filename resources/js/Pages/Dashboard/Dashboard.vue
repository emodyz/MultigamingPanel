<template>
  <app-layout>
    <template #header>
      <h2 class="breadcrumb">
        Dashboard
      </h2>
    </template>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div v-if="can('dashboard-stats')" class="grid grid-cols-6 gap-6">
          <users-chart class="col-span-6 md:col-span-6" :stats="usersStats"/>
          <users-chart v-for="server in serversStats"
                       :key="server.total+Math.random()"
                       class="col-span-6 md:col-span-3"
                       :stats="server"/>
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script lang="ts">
import {
  Component, Prop, Mixins,
} from 'vue-property-decorator'

import AppLayout from '@/Layouts/AppLayout.vue'
import Welcome from '@/Jetstream/Welcome.vue'
import UsersChart from '@/Pages/Dashboard/Components/UsersChart.vue'
import Cerberus from '@/Mixins/Cerberus'

@Component({
  components: {
    AppLayout,
    Welcome,
    UsersChart,
  },
})
export default class Dashboard extends Mixins(Cerberus) {
  @Prop() usersStats !: any

  @Prop() serversStats !: any
}
</script>
