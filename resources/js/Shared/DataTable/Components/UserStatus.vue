<template>
  <div>
    <span
        v-if="email_verified_at"
        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800
        dark:text-emerald-300 dark:bg-emerald-900"
    >
      Active
    </span>
    <span
        v-else
        class="px-2 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800
        dark:bg-gray-900 dark:border dark:broder-geay-700 dark:text-gray-300"
    >
      Awaiting Email Validation
    </span>
  </div>
</template>

<script lang="ts">
import { Component, Prop, Mixins } from 'vue-property-decorator'
import Helpers from '@/Mixins/Helpers'

@Component
// eslint-disable-next-line camelcase
export default class DataTable_UserStatus extends Mixins(Helpers) {
  @Prop({ required: true }) readonly data!: any

  @Prop({ required: true }) readonly dataAccessors!: any

  email_verified_at: string = this.getWithDataAccessors(this.data, this.dataAccessors.email_verified_at)
}
</script>
