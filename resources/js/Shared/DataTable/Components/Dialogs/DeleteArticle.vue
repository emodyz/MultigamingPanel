<template>
  <div>
    <span class="text-md">Are you sure you would like to delete this article ?</span>

    <div class="w-88 flex flex-col justify-center items-center">
      <div class="bg-gray-300 h-56 w-full rounded-lg shadow-md bg-cover bg-center" :style="`background-image: url('${ data.cover_image_url }')`"></div>

      <div class="prose w-80 bg-white -mt-10 shadow-lg rounded-lg overflow-hidden p-5">
        <h3>{{ data.title }}</h3>

        <div class="text-base">
          {{ data.subTitle }}
        </div>

      </div>
    </div>
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
export default class DeleteArticle extends Vue {
  @Prop({ type: Object, required: true }) readonly data!: any
}
</script>
