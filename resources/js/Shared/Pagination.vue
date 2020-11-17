<template>
    <div class="mt-6 -mb-1 flex flex-wrap">
        <template v-for="(link, key) in links">
            <div v-if="link.url === null" :key="key" class="mr-1 mb-1 px-4 py-3 text-sm border rounded text-gray-400">{{ link.label }}</div>
            <Inertia-link v-else preserve-scroll preserve-state :key="key" class="mr-1 mb-1 px-4 py-3 text-sm border rounded hover:bg-white focus:border-indigo-500 focus:text-indigo-500" :class="{ 'bg-white border-indigo-500 text-indigo-500': link.active }" :href="link.url">{{ link.label }}</Inertia-link>
        </template>
    </div>
</template>

<script lang="ts">
    import {Vue, Component, Prop} from 'vue-property-decorator'

    @Component
    export default class Pagination extends Vue {
        @Prop() readonly links!: Array<any>
    }
</script>
