<template>
  <modal
      :show="show"
      :max-width="maxWidth"
      :closeable="closeable"
      @close="close"
  >
    <div class="px-6 py-4 dark:bg-zinc-800">
      <div class="text-lg dark:text-zinc-100">
        <slot name="title"/>
      </div>

      <div class="mt-4 dark:text-zinc-300">
        <slot name="content"/>
      </div>
    </div>

    <div class="px-6 py-4 bg-zinc-100 dark:bg-zinc-700 text-right">
      <slot name="footer"/>
    </div>
  </modal>
</template>

<script lang="ts">
import { Vue, Component, Prop } from 'vue-property-decorator'
import Modal from './Modal.vue'

@Component({
  components: {
    Modal,
  },
})
export default class DialogModal extends Vue {
  @Prop({ default: true }) readonly closeable!: boolean

  @Prop({ default: true }) readonly show!: boolean

  @Prop({ default: '2xl' }) readonly maxWidth!: string

  close() {
    this.$emit('close')
  }
}
</script>
