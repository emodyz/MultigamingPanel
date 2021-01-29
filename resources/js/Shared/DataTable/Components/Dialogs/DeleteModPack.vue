<template>
  <div>
    <div class="p-3 rounded-md bg-red-500 text-red-50 font-semibold">
      This action will delete all modpacks files !
    </div>
    <div class="my-3">
      <span class="text-md">Are you sure you would like to delete this modpack ?</span>
    </div>
    <div class="flex justify-between items-center border rounded-md p-3">
      <div class="flex flex-col text-sm">
        <div>
          <span class="font-medium">Name:</span>
          <span class="font-bold">{{ data.name }}</span>
        </div>
        <div>
          <span class="font-medium">Assigned Servers:</span>
          <span class="font-bold">{{ data.servers.length }}</span>
        </div>
        <div>
          <span class="font-medium">Size:</span>
          <DtModPackSize class="inline-flex" :data="data"></DtModPackSize>
        </div>
      </div>
      <dt-game-profile :data="data" :data-accessors="{name: 'game.name', logo_url: 'game.logo_url'}"></dt-game-profile>
    </div>
  </div>
</template>

<script lang="ts">
import { Vue, Component, Prop } from 'vue-property-decorator'
import DtGameProfile from '@/Shared/DataTable/Components/BasicProfile.vue'
import DtModPackSize from '@/Shared/DataTable/Components/ModPackSize.vue'

@Component({
  components: {
    DtGameProfile,
    DtModPackSize,
  },
})
export default class DeleteModPack extends Vue {
    @Prop({ type: Object, required: true }) readonly data!: any
}
</script>
