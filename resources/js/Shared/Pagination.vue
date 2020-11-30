<template>
    <div class="mt-6 -mb-1 flex flex-wrap">
        <template v-for="(link, key) in links">
            <jet-button v-if="link.label === 'Next' || link.label === 'Previous'"
                        type="link"
                        :disabled="!link.url"
                        :key="key"
                        class="mr-1 text-sm">
                <Inertia-link v-if="link.url" preserve-scroll preserve-state :href="link.url ? link.url : '#'">{{ link.label }}</Inertia-link>
                <span v-else>{{ link.label }}</span>
            </jet-button>
            <jet-secondary-button v-else
                                  :key="key"
                                  type="link"
                                  :disabled="!link.url"
                                  :class="{ 'border-indigo-500 text-indigo-500': link.active }"
                                  class="mr-1 text-sm">
                <Inertia-link v-if="link.url" preserve-scroll preserve-state :href="link.url ? link.url : '#'">{{ link.label }}</Inertia-link>
                <span v-else>{{ link.label }}</span>
            </jet-secondary-button>
        </template>
    </div>
</template>

<script lang="ts">
    import {Vue, Component, Prop} from 'vue-property-decorator'
    import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue";
    import JetButton from "@/Jetstream/Button.vue";

    @Component({
        components: {
            JetSecondaryButton,
            JetButton
        }
    })
    export default class Pagination extends Vue {
        @Prop() readonly links!: Array<any>

        created() {
            console.log(this.links)
        }
    }
</script>
