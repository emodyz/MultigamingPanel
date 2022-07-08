<template>
  <div class="mx-2 leading-6 flex flex-auto flex-wrap items-center w-full">
    <div class="mr-4">
      <img
          class="h-10 w-10 object-cover rounded-full"
          :src="logo"
          :alt="name"
      >
    </div>
    <div class="flex-1">{{ name }}</div>
    <div class="justify-self-end font-semibold px-2 rounded-full text-indigo-700 bg-indigo-100 border border-indigo-300
    dark:bg-indigo-500 dark:text-zinc-100 dark:border-transparent">{{ game.name }}</div>
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
