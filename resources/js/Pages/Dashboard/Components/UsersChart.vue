<template>
  <div class="h-40 rounded-lg bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 shadow-lg relative overflow-hidden"
      :class="{'animate-pulse': !stats}">
    <div v-if="stats" class="px-3 pt-8 pb-10 text-center relative z-10">
      <h4 class="text-md uppercase text-gray-500 dark:text-gray-100 leading-tight">Users</h4>
      <h3 class="text-3xl text-gray-700 dark:text-gray-300 font-semibold leading-tight my-3">{{ stats.total }}</h3>
      <div v-if="stats.dailyDiff !== null">
        <p v-if="stats.isDailyDiffPositive" class="text-sm text-green-500 dark:text-emerald-500 leading-tight">▲ {{stats.dailyDiff}}%</p>
        <p v-else class="text-sm text-red-500 leading-tight">▼ {{stats.dailyDiff}}%</p>
      </div>
    </div>
    <div class="absolute h-40 bottom-0 inset-x-0">
      <canvas ref="chart" class="h-40"></canvas>
    </div>
  </div>
</template>

<script lang="ts">
import {
  Component, Mixins, Ref,
} from 'vue-property-decorator'
import { Chart, ChartOptions } from 'chart.js'
import Route from '@/Mixins/Route'

@Component
export default class UsersChart extends Mixins(Route) {
  @Ref('chart') readonly chart!: any

  stats: any = null

  chartOptions: ChartOptions | any = {
    layout: {
      padding: {
        top: 5,
        left: 0,
        bottom: 0,
      },
    },
    maintainAspectRatio: false,
    legend: {
      display: false,
    },
    tooltips: {
      enabled: false,
    },
    elements: {
      point: {
        radius: 0,
      },
    },
    scales: {
      xAxes: [
        {
          gridLines: false,
          scaleLabel: false,
          ticks: {
            display: false,
          },
        },
      ],
      yAxes: [
        {
          gridLines: false,
          scaleLabel: false,
          ticks: {
            display: false,
            suggestedMin: 0,
            suggestedMax: 10,
          },
        },
      ],
    },
  }

  mounted() {
    this.initChart()
  }

  async initChart() {
    const res = await this.$axios.get(this.route('api.dashboard.stats.users'))

    this.stats = res.data
    //
    const ctx = this.chart.getContext('2d')
    // eslint-disable-next-line no-new
    /* const chart = */ new Chart(ctx, {
      type: 'line',
      data: {
        labels: this.stats.graphData,
        datasets: [
          {
            backgroundColor: 'rgba(167, 139, 250, 0.1)',
            borderColor: 'rgba(167, 139, 250, 0.8)',
            borderWidth: 2,
            data: this.stats.graphData,
          },
        ],
      },
      options: this.chartOptions,
    })
    console.log(this.stats)
  }
}
</script>
