<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Users <span class="text-gray-400">/</span> Edit / {{ userBeingEdited.name }}
      </h2>
    </template>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <edit-user-profile-form :user="userBeingEdited" />
        <jet-section-border />
        <!-- TODO: Extract permission checks -->
        <edit-user-account-form
          v-if="can('users-edit-account')"
          :user="userBeingEdited"
          :roles="roles"
          class="mt-10 sm:mt-0"
        />
      </div>
    </div>
  </app-layout>
</template>

<script lang="ts">

import { Vue, Component, Prop } from 'vue-property-decorator'
import AppLayout from '@/Layouts/AppLayout.vue'
import { User } from '@/Shared/DataTable/Types/User.d.ts'
import EditUserProfileForm from '@/Pages/Users/EditUserProfileForm.vue'
import EditUserAccountForm from '@/Pages/Users/EditUserAccountForm.vue'
import JetSectionBorder from '@/Jetstream/SectionBorder.vue'
import { hasAuthorizationTo } from '@/Shared/Helpers/cerberus.ts'

@Component({
  components: {
    AppLayout,
    EditUserProfileForm,
    EditUserAccountForm,
    JetSectionBorder,
  },
})
export default class UsersEdit extends Vue {
    @Prop() readonly userBeingEdited!: User

    @Prop() readonly UserPermissions!: Array<string>

    @Prop() readonly roles!: any

    can = hasAuthorizationTo

    created() {
    }
}
</script>
