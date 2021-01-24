<template>
  <div class="flex items-center">
      <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
      {{ humanFileSize(size) }}
    </span>
  </div>
</template>

<script lang="ts">
import { Vue, Component, Prop } from 'vue-property-decorator'

@Component
export default class DataTable_ModPackSize extends Vue {
  @Prop({ required: true }) readonly data!: any

  size: any = this.data.manifest_info.size

  humanFileSize(bytes: number, si = true, dp = 1) {
    const thresh = si ? 1000 : 1024

    if (Math.abs(bytes) < thresh) {
      return `${bytes} B`
    }

    const units = si
      ? ['kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB']
      : ['KiB', 'MiB', 'GiB', 'TiB', 'PiB', 'EiB', 'ZiB', 'YiB']
    let u = -1
    const r = 10 ** dp

    do {
      // eslint-disable-next-line no-param-reassign
      bytes /= thresh
      // eslint-disable-next-line no-plusplus
      ++u
    } while (Math.round(Math.abs(bytes) * r) / r >= thresh && u < units.length - 1)

    return `${bytes.toFixed(dp)} ${units[u]}`
  }
}
</script>
