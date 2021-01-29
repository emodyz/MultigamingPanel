<template>
  <div>
    <span class="text-md">Are you sure you would like to delete this server ?</span>
    <dt-server-profile
        class="my-4"
        :data="data"
        :data-accessors="{
          name: 'name',
          logo_url: 'logo_url',
          ip: 'ip',
            port: 'port',
        }"
    />
  </div>
</template>

<script lang="ts">
import { Vue, Component, Prop } from 'vue-property-decorator'
import DtServerProfile from '@/Shared/DataTable/Components/ServerProfile.vue'

@Component({
  components: {
    DtServerProfile,
  },
})
export default class DeleteServer extends Vue {
  @Prop({
    type: Object,
    required: true,
  }) readonly data!: any
}
</script>
