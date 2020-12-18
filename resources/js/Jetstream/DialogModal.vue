<template>
  <modal
    :show="show"
    :max-width="maxWidth"
    :closeable="closeable"
    @close="close"
  >
    <div class="px-6 py-4">
      <div class="text-lg">
        <slot name="title"/>
      </div>

      <div class="mt-4">
        <slot name="content"/>
      </div>
    </div>

    <div class="px-6 py-4 bg-gray-100 text-right">
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
