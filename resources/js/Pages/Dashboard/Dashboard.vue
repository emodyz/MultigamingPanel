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
          <users-chart class="col-span-6 md:col-span-6"/>
          <jet-section-border class="col-span-6" padding="py-0"/>
          <server-chart v-for="server in serversStats"
                        :stats="server"
                       :key="server.total+Math.random()"
                       class="col-span-6 md:col-span-3"/>
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script lang="ts">
import {
  Component, Mixins,
} from 'vue-property-decorator'

import AppLayout from '@/Layouts/AppLayout.vue'
import Welcome from '@/Jetstream/Welcome.vue'
import UsersChart from '@/Pages/Dashboard/Components/UsersChart.vue'
import Cerberus from '@/Mixins/Cerberus'
import ServerChart from '@/Pages/Dashboard/Components/ServerChart.vue'
import JetSectionBorder from '@/Jetstream/SectionBorder.vue'
import { collect } from 'collect.js'
import Route from '@/Mixins/Route'

@Component({
  components: {
    AppLayout,
    Welcome,
    UsersChart,
    ServerChart,
    JetSectionBorder,
  },
})
export default class Dashboard extends Mixins(Cerberus, Route) {
  serversStats = collect()

  async created() {
    const res = await this.$axios.get(this.route('api.dashboard.stats.servers'))

    this.serversStats = collect(res.data)

    console.log(this.serversStats)
  }
}
</script>
