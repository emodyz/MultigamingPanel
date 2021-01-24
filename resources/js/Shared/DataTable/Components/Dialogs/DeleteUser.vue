<template>
  <div>
    <span class="text-md">Are you sure you would like to delete this user ?</span>
    <dt-user-profile
        class="my-4"
        :email="data.email"
        :name="data.name"
        :profile_photo_url="data.profile_photo_url"
    />
  </div>
</template>

<script lang="ts">
import { Vue, Component, Prop } from 'vue-property-decorator'
import DtUserProfile from '@/Shared/DataTable/Components/UserProfile.vue'

@Component({
  components: {
    DtUserProfile,
  },
})
export default class DeleteUser extends Vue {
    @Prop({ type: Object, required: true }) readonly data!: any
}
</script>
