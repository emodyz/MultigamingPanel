<template>
  <div class="flex items-center">
    <div class="flex-shrink-0 h-10 w-10">
      <img
        class="h-10 w-10 rounded-full object-cover"
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
import { Component, Prop, Mixins } from 'vue-property-decorator'
import Helpers from '@/Mixins/Helpers'

@Component
export default class DataTable_UserProfile extends Mixins(Helpers) {
  @Prop({ required: true }) readonly data!: any

  @Prop({ required: true }) readonly dataAccessors!: any

  name: string = this.getWithDataAccessors(this.data, this.dataAccessors.name)

  email: string = this.getWithDataAccessors(this.data, this.dataAccessors.email)

  profile_photo_url: string = this.getWithDataAccessors(this.data, this.dataAccessors.profile_photo_url)
}
</script>
