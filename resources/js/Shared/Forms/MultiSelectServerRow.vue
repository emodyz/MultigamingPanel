<template>
  <div class="mx-2 leading-6 inline-flex justify-start items-center w-full">
    <div>{{ name }}</div>
    <div class="m-1 font-medium py-1 px-2 bg-white rounded-full text-indigo-700 bg-indigo-100 border border-indigo-300">{{ game.name }}</div>
  </div>
</template>

<script lang="ts">
import { Vue, Component, Prop } from 'vue-property-decorator'

@Component
export default class MultiSelectServerRow extends Vue {
  @Prop({ type: String, required: true }) readonly name !: string

  @Prop({ type: String, required: true }) readonly logo !: string

  @Prop({ type: Object, required: true }) readonly game !: any
}
</script>
