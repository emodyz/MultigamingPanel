<template>
    <div class="flex items-center">
    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-200 text-indigo-800
     dark:bg-indigo-500 dark:text-zinc-100">
        <span v-if="files === 0"> No Files</span>
        <span v-else-if="files === 1">{{ files }} File</span>
        <span v-else-if="files > 1">{{ files }} Files</span>
    </span>
    </div>
</template>

<script lang="ts">
import { Vue, Component, Prop } from 'vue-property-decorator'

@Component
export default class DataTable_ModPackFiles extends Vue {
  @Prop({ required: true }) readonly data!: any

  files: any = this.data.manifest_info.files
}
</script>
