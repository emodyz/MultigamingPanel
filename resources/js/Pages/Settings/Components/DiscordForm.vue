<template>
    <!-- Name -->
    <div class="col-span-6 sm:col-span-4">
        <jet-label
                for="type"
                value="Please enter your Discord ServerId"
        />
        <jet-input
                id="server"
                v-model="form.payload.serverId"
                type="text"
                class="mt-1 block w-full"
                autocomplete="server"
        />
        <jet-input-error
                v-if="form.errors.payload"
                :message="form.errors.payload"
                class="mt-2"
        />
        <div class="text-center mt-4">
            <a target="_blank" href="https://support.discord.com/hc/en-us/articles/206346498-Where-can-I-find-my-User-Server-Message-ID-">
                <span class="text-indigo-600 font-semibold">Where can I find my Discord ServerId ?</span>
            </a>
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
export default class DiscordForm extends Vue {
  @Prop({ required: true }) form!: any;

  created() {
    if (!this.form.payload.serverId) {
      this.form.payload.serverId = null
    }
  }
}
</script>

<style scoped>

</style>
