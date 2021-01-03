<template>
  <div class="flex items-center">
    <div class="flex-shrink-0 h-10 w-10">
      <img
        class="h-10 w-10 rounded-full"
        :src="logo_url"
        :alt="name"
      >
    </div>
    <div class="ml-4">
      <div class="text-sm font-semibold text-gray-900">
        {{ name }}
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { Vue, Component, Prop } from 'vue-property-decorator'

@Component
// eslint-disable-next-line camelcase
export default class DataTable_GameProfile extends Vue {
    @Prop({ type: String, required: true }) readonly name!: string

    @Prop({ type: String, required: true }) readonly logo_url!: string
}
</script>
