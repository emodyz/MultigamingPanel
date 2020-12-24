<template>
  <div>
    <span
      v-if="email_verified_at"
      class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800"
    >
      Active
    </span>
    <span
      v-else
      class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800"
    >
      Awaiting Email Validation
    </span>
  </div>
</template>

<script lang="ts">
import { Vue, Component, Prop } from 'vue-property-decorator'

@Component
// eslint-disable-next-line camelcase
export default class DataTable_UserStatus extends Vue {
    @Prop({ required: true }) readonly email_verified_at!: string | null
}
</script>
