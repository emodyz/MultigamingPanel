<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                ModPacks <span class="text-gray-400">/</span> Update <span class="text-gray-400">/</span>
                {{ modpack.name }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto flex flex-col justify-center md:max-w-7xl md:flex-row">
                <div class="w-full bg-white shadow overflow-hidden md:w-1/2 md:mx-5 md:rounded-lg">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            ModPack Information
                        </h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">
                            Files details and application.
                        </p>
                    </div>
                    <div class="border-t border-gray-200">
                        <dl>
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">
                                    Name
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ modpack.name }}
                                </dd>
                            </div>
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">
                                    Path
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ modpack.path }}
                                </dd>
                            </div>
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">
                                    Game
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    <game-profile :name="modpack.game.name" :logo_url="modpack.game.logo_url"/>
                                </dd>
                            </div>
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">
                                    Last update
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    <span v-if="modpack.manifest_last_update === null">Never</span>
                                    <span v-else>{{
                                            $moment(modpack.manifest_last_update)
                                                    .fromNow()
                                        }}</span>
                                </dd>
                            </div>
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">
                                    Total Files
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    <modpack-files :files="modpack.manifest_info.files"></modpack-files>
                                </dd>
                            </div>
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">
                                    Total Size
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    <modpack-size :size="modpack.manifest_info.size"></modpack-size>
                                </dd>
                            </div>
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">
                                    Attached Servers
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    <ul class="border border-gray-200 rounded-md divide-y divide-gray-200">
                                        <li v-if="modpack.servers.length === 0"
                                            class="pl-3 pr-4 py-3 flex items-center text-sm">
                                            <span class="truncate">
                                                No attached servers.
                                            </span>
                                        </li>
                                        <li v-for="server of modpack.servers" v-else :key="server.id"
                                            class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                                            <div class="w-0 flex-1 flex items-center">
                                                <svg class="flex-shrink-0 h-5 w-5 text-gray-400"
                                                     fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"
                                                          stroke-linecap="round"
                                                          stroke-linejoin="round"
                                                          stroke-width="2"/>
                                                </svg>
                                                <span class="ml-2 flex-1 w-0 truncate">
                                                    {{ server.name }}
                                            </span>
                                            </div>
                                            <div class="ml-4 flex-shrink-0">
                                                <a class="font-medium text-indigo-600 hover:text-indigo-500" href="#">
                                                    See
                                                </a>
                                            </div>
                                        </li>
                                    </ul>
                                </dd>
                            </div>
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-1 sm:gap-4 sm:px-6">
                                <jet-button class="ml-auto" @click="goToModPackEdit">
                                    Edit
                                </jet-button>
                            </div>
                        </dl>
                    </div>
                </div>

                <div class="flex flex-col justify-end overflow-hidden w-full mt-4 md:mx-5 bg-white shadow md:mt-0 md:w-1/2 md:rounded-lg">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            ModPack Update Control
                        </h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">
                            Below, you can start a new modpack update.
                        </p>
                    </div>
                    <div class="flex flex-col justify-center items-center border-t border-gray-200 p-2 text-sm">
                        <div class="flex flex-col justify-center w-full p-4" v-if="inProgress">
                            <span class="text-indigo-500 text-center text-thin text-xl">
                                {{progress}} %
                            </span>

                            <div class="flex overflow-hidden w-full h-4 mt-4 text-xs rounded bg-indigo-200">
                                <div class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-indigo-500 progress-animation" v-bind:style="{ width: progress + '%' }"></div>
                            </div>

                            <div v-if="loadingGif" class="flex justify-center my-auto items-center w-full mt-3 p-2">
                                <img :src="loadingGif">
                            </div>
                        </div>
                        <div class="w-full h-full mt-4 px-10 py-3 md:mt-16" v-else>
                            <UpdateIllustration/>
                        </div>
                    </div>
                    <div class="mt-auto px-4 py-5 bg-gray-50 sm:grid sm:grid-cols-1 sm:gap-4 sm:px-6 md:rounded-b-lg">

                        <jet-secondary-button v-if="!inProgress" :disabled="waitToStart" class="w-full justify-center"
                                              @click.native="startUpdate">
                            <spinner v-if="waitToStart" class="text-gray-500"/>
                            Update Now
                        </jet-secondary-button>

                        <jet-danger-button v-if="inProgress" :disabled="waitToCancel" class="w-full"
                                           @click.native="cancelUpdate">
                            <spinner v-if="waitToCancel" class="text-gray-100"/>
                            Cancel update
                        </jet-danger-button>
                    </div>
                </div>
            </div>
        </div>

    </app-layout>
</template>

<script lang="ts">
import {
  Component, Mixins, Prop,
} from 'vue-property-decorator'
import AppLayout from '@/Layouts/AppLayout.vue'
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'
import JetDangerButton from '@/Jetstream/DangerButton.vue'
import JetButton from '@/Jetstream/Button.vue'
import Route from '@/Mixins/Route'
import Spinner from '@/Shared/Svgs/Spinner.vue'
import ModpackSize from '@/Shared/DataTable/Components/ModPackSize.vue'
import ModpackFiles from '@/Shared/DataTable/Components/ModPackFiles.vue'
import GameProfile from '@/Shared/DataTable/Components/GameProfile.vue'
import UpdateIllustration from '@/Shared/Svgs/UpdateIllustration.vue'

@Component({
  components: {
    UpdateIllustration,
    GameProfile,
    ModpackFiles,
    ModpackSize,
    Spinner,
    AppLayout,
    JetSecondaryButton,
    JetDangerButton,
    JetButton,
  },
})
export default class ModPacks_Update extends Mixins(Route) {
  @Prop() readonly modpack!: any

  progress: number = 0

  inProgress: boolean = false

  waitToStart: boolean = false

  waitToCancel: boolean = false

  modpackUpdateLoading: boolean = false

  loadingGif: string | null = null

  mounted() {
    if (this.modpack.batch !== null) {
      this.inProgress = true
      this.progress = this.modpack.batch.progress
    }

    this.$echo.private(`modPacks.${this.modpack.id}`)
      .listen('ModPack\\ModPackProcessStarted', () => {
        this.waitToStart = false
        this.progress = 0
        this.inProgress = true
      })
      .listen('ModPack\\ModPackProcessProgress', (e: any) => {
        this.progress = e.progress
      })
      .listen('ModPack\\ModPackProcessDone', () => {
        this.handleDownloadEnded()
      })
      .listen('ModPack\\ModPackProcessFailed', () => {
        this.handleDownloadEnded()
      })
      .listen('ModPack\\ModPackProcessCanceled', () => {
        this.handleDownloadEnded()
      })
  }

  handleDownloadEnded() {
    this.$inertia.reload({
      only: ['modpack'],
    })

    this.inProgress = false
    this.waitToCancel = false
    this.waitToStart = false
  }

  goToModPackEdit() {
    this.$inertia.visit(this.route('modpacks.edit', this.modpack.id))
  }

  async startUpdate() {
    this.modpackUpdateLoading = true
    this.waitToStart = true
    try {
      await this.$axios.post(
        this.route('modpacks.update.start', this.modpack.id),
        {},
      )
      this.loadingGif = (await fetch('https://api.thecatapi.com/v1/images/search?mime_types=gif').then((res) => res.json()))[0].url
    } catch (e) {
      console.error(e)
    }

    this.modpackUpdateLoading = false
  }

  async cancelUpdate() {
    this.modpackUpdateLoading = true
    this.waitToCancel = true

    await this.$axios.delete(
      this.route('modpacks.update.cancel', this.modpack.id),
      {},
    )
    this.modpackUpdateLoading = false
  }
}
</script>

<style scoped>
.progress-animation {
    transition: width 200ms;
}
</style>
