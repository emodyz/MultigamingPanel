<template>
  <div class="flex items-center">
    <div class="flex-shrink-0 h-10 w-10">
      <img
        class="h-10 w-10 rounded-full"
        :src="profile_photo_url"
        :alt="`Avatar of user ${name}`"
      >
    </div>
    <div class="ml-4">
      <div class="text-sm font-medium text-gray-900">
        {{ name }}
      </div>
      <div class="text-sm text-gray-500">
        {{ email }}
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { Vue, Component, Prop } from 'vue-property-decorator'

@Component
// eslint-disable-next-line camelcase
export default class DataTable_UserProfile extends Vue {
    @Prop({ type: String, required: true }) readonly name!: string

    @Prop({ type: String, required: true }) readonly email!: string

    // eslint-disable-next-line camelcase
    @Prop({ type: String, required: true }) readonly profile_photo_url!: string
}
</script>
