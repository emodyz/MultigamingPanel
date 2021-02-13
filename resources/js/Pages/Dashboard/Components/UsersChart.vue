<template>
  <div class="h-40 rounded-lg bg-white dark:bg-gray-800 box-border shadow-lg md:shadow-xl relative overflow-hidden">
    <div class="px-3 pt-8 pb-10 text-center relative z-10">
      <h4 class="text-sm uppercase text-gray-500 dark:text-gray-100 leading-tight">Users</h4>
      <h3 class="text-3xl text-gray-700 dark:text-gray-300 font-semibold leading-tight my-3">{{ stats.total }}</h3>
      <p v-if="stats.isPositive" class="text-xs text-green-500 dark:text-emerald-500 leading-tight">▲ {{stats.dailyDifferance}}%</p>
      <p v-else class="text-xs text-red-500 leading-tight">▼ {{stats.dailyDifferance}}%</p>
    </div>
    <div class="absolute h-40 bottom-0 inset-x-0">
      <canvas ref="chart1" class="h-40"></canvas>
    </div>
  </div>
</template>

<script lang="ts">
import {
  Vue, Component, Ref, Prop,
} from 'vue-property-decorator'
import { Chart, ChartOptions } from 'chart.js'

@Component
export default class UsersChart extends Vue {
  @Prop({ required: true }) readonly stats!:any

  @Ref('chart1') readonly chart1!: any

  mounted() {
    const chartOptions: ChartOptions | any = {
      layout: {
        padding: {
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
    //
    const ctx = this.chart1.getContext('2d')
    const chart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: this.stats.graphData,
        datasets: [
          {
            backgroundColor: 'rgba(101, 116, 205, 0.1)',
            borderColor: 'rgba(101, 116, 205, 0.8)',
            borderWidth: 2,
            data: this.stats.graphData,
          },
        ],
      },
      options: chartOptions,
    })
    console.log(chart)
  }
}
</script>
