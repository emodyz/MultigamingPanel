<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Users <span class="text-gray-400">/</span> Edit / {{ userBeingEdited.name }}
      </h2>
    </template>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <edit-user-profile-form v-if="canEditProfile" :user="userBeingEdited"/>
        <div v-if="canEditAccount">
          <jet-section-border/>
          <edit-user-account-form
              :user="userBeingEdited"
              :roles="roles"
              class="mt-10 sm:mt-0"
          />
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script lang="ts">

import { Mixins, Component, Prop } from 'vue-property-decorator'
import AppLayout from '@/Layouts/AppLayout.vue'
import { User } from '@/Shared/DataTable/Types/User'
import EditUserProfileForm from '@/Pages/Users/EditUserProfileForm.vue'
import EditUserAccountForm from '@/Pages/Users/EditUserAccountForm.vue'
import JetSectionBorder from '@/Jetstream/SectionBorder.vue'
import Cerberus from '@/Mixins/Cerberus'
import ZigRoute from '@/Mixins/Route'

@Component({
  components: {
    AppLayout,
    EditUserProfileForm,
    EditUserAccountForm,
    JetSectionBorder,
  },
})
export default class UsersEdit extends Mixins(Cerberus, ZigRoute) {
  @Prop() readonly userBeingEdited!: User

  @Prop() readonly roles!: any

  canEditProfile = false

  canEditAccount = false

  async created() {
    this.canEditProfile = await this.Cerberus.can('users-edit')
    this.canEditAccount = await this.Cerberus.can('users-edit-account')
  }
}
</script>
