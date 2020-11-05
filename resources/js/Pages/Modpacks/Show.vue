<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Modpack: {{ modpack.name }}
            </h2>
        </template>

        <div class="py-12">
            <div class="flex flex-row flex-wrap max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="p-2 w-2/3">
                    <div class="bg-white overflow-hidden shadow-xl rounded-lg p-4">
                        Name: {{ modpack.name }}
                    </div>
                </div>
                <div class="p-2 w-1/3">
                    <div class="bg-white overflow-hidden shadow-xl rounded-lg p-4">
                        <div class="h-10 mb-2">
                            <span class="font-semibold ">
                                You can run an update of this modpack below !
                            </span>
                        </div>

                        <div class="relative pt-1">
                            <div v-if="inProgress" class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-pink-200">
                                <div
                                    class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-pink-500 progress-animation"
                                    v-bind:style="{ width: progress + '%' }"></div>
                            </div>
                        </div>


                        <jet-secondary-button v-if="!inProgress" class="w-full" @click.native="startUpdate">
                            Update Now
                        </jet-secondary-button>

                        <jet-danger-button v-if="inProgress" class="w-full" @click.native="cancelUpdate">
                            Cancel update
                        </jet-danger-button>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script lang="ts">
import AppLayout from '@/Layouts/AppLayout.vue'

import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue";
import JetDangerButton from "@/Jetstream/DangerButton.vue";


import {Component, Prop, Vue} from 'vue-property-decorator'

@Component({
    components: {
        AppLayout,
        JetSecondaryButton,
        JetDangerButton
    },
})
export default class Dashboard extends Vue {
    @Prop() modpack!: any;

    progress: number = 0;
    inProgress: boolean = false;

    modpackUpdateLoading: boolean = false;

    mounted() {
        if (this.modpack.batch !== null) {
            this.inProgress = true;
            this.progress = this.modpack.batch.progress;
        }

        this.$echo.private(`modpacks.${this.modpack.id}`)
            .listen('Modpack\\ModpackProcessStarted', (e: any) => {
                this.progress = 0;
                this.inProgress = true;
            }).listen('Modpack\\ModpackProcessProgress', (e: any) => {
            this.progress = e.progress;
        }).listen('Modpack\\ModpackProcessDone', (e: any) => {
            this.inProgress = false;
        }).listen('Modpack\\ModpackProcessFailed', (e: any) => {
            this.inProgress = false;
        }).listen('Modpack\\ModpackProcessCanceled', (e: any) => {
            this.inProgress = false;
        });
    }

    async startUpdate() {
        this.modpackUpdateLoading = true;
        try {
            await this.$axios.post(
                // @ts-ignore
                route('modpacks.update.start', this.modpack.id),
                {}
            )
        } catch (e) {
        }
        this.modpackUpdateLoading = false;
    }

    async cancelUpdate() {
        this.modpackUpdateLoading = true;
        await this.$axios.delete(
            // @ts-ignore
            route('modpacks.update.cancel', this.modpack.id),
            {}
        )
        this.modpackUpdateLoading = false;
    }
}
</script>

<style scoped>
.progress-animation {
    transition: width 200ms;
}
</style>
