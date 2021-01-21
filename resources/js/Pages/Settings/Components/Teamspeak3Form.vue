<template>
   <div class="col-span-6 sm:col-span-4">
       <!-- Ip -->
       <div class="col-span-6 sm:col-span-4">
           <jet-label
                   for="type"
                   value="IP"
           />
           <jet-input
                   id="ip"
                   v-model="form.payload.ip"
                   type="text"
                   class="mt-1 block w-full"
                   autocomplete="ip"
           />
           <jet-input-error
                   v-if="form.errors.payload"
                   :message="form.errors.payload"
                   class="mt-2"
           />
       </div>
       <!-- Port -->
       <div class="col-span-6 sm:col-span-4 mt-3">
           <jet-label
                   for="type"
                   value="PORT"
           />
           <jet-input
                   id="port"
                   v-model="form.payload.port"
                   type="text"
                   class="mt-1 block w-full"
                   autocomplete="port"
           />
           <jet-input-error
                   v-if="form.errors.payload"
                   :message="form.errors.payload"
                   class="mt-2"
           />
       </div>
   </div>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator'
import JetLabel from '@/Jetstream/Label.vue'
import JetInputError from '@/Jetstream/InputError.vue'
import JetInput from '@/Jetstream/Input.vue'

@Component({
  components: {
    JetLabel,
    JetInputError,
    JetInput,
  },
})
export default class TeamSpeak3Form extends Vue {
  @Prop({ required: true }) form!: any;

  created() {
    if (!this.form.payload.ip || !this.form.payload.port) {
      this.form.payload = {
        ip: null,
        port: null,
      }
    }
  }
}
</script>

<style scoped>

</style>
