<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Modpacks List
            </h2>
        </template>

        <div class="py-12">
            <div class="flex max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mr-2 w-3/4">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                        <tr>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                scope="col">
                                Name
                            </th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                scope="col">
                                Servers
                            </th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                scope="col">
                                Size
                            </th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                scope="col">
                                Files
                            </th>
                            <th class="px-6 py-3 bg-gray-50" scope="col">
                                <span class="sr-only">Actions</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody :key="modpack.name" v-for="modpack of modpacks" class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <img alt="" class="h-10 w-10 rounded-full"
                                             src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=facearea&amp;facepad=4&amp;w=256&amp;h=256&amp;q=60">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ modpack.name }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            Cool modpack !
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    {{ modpack.servers.map((server) => server.name).join(', ') }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                      {{ humanFileSize(modpack.manifest_info.size) }}
                                    </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                      {{ modpack.manifest_info.files }}
                                    </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <inertia-link :href="route('modpacks.show', modpack.id)"
                                              class="inline-flex items-center px-2 py-1 mx-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150">
                                    Edit
                                </inertia-link>
                                <span
                                    class="cursor-pointer inline-flex items-center justify-center px-2 py-1 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:outline-none focus:border-red-700 focus:shadow-outline-red active:bg-red-600 transition ease-in-out duration-150"
                                    @click="deleteModpackId = modpack.id">
                                        Delete
                                    </span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg ml-2 p-4 w-1/4">
                    <form @submit.prevent="createModpack">
                        <span class="text-md font-bold">
                            Create Modpack
                        </span>
                        <div class="mt-3">
                            <jet-label for="name" value="Name"/>
                            <jet-input id="name" v-model="name" class="w-full mb-3" placeholder="Enter Name"/>
                            <jet-secondary-button
                                :class="{ 'opacity-25': processing }"
                                :disabled="processing"
                                type="submit">
                                Create
                            </jet-secondary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <jet-confirmation-modal :show="deleteModpackId" @close="deleteModpackId = null">
            <template #title>
                Delete Modpack
            </template>

            <template #content>
                Are you sure you want to delete this modpack?
                Once this modpack is deleted, all of its resources and data will be permanently deleted.
            </template>

            <template #footer>
                <jet-secondary-button @click.native="deleteModpackId = null">
                    No ! No ! No !
                </jet-secondary-button>

                <jet-danger-button :class="{ 'opacity-25': processing }" :disabled="processing" class="ml-2"
                                   @click.native="deleteModpack">
                    Delete Modpack
                </jet-danger-button>
            </template>
        </jet-confirmation-modal>
    </app-layout>
</template>

<script lang="ts">
import AppLayout from '@/Layouts/AppLayout.vue'
import JetNavLink from '@/Jetstream/NavLink.vue'
import JetLabel from '@/Jetstream/Label.vue'
import JetInput from '@/Jetstream/Input.vue'
import JetInputError from '@/Jetstream/InputError.vue'
import JetConfirmationModal from '@/Jetstream/ConfirmationModal.vue'
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'
import JetDangerButton from '@/Jetstream/DangerButton.vue'

import { Component, Prop, Vue } from 'vue-property-decorator'

@Component({
  components: {
    AppLayout,
    JetNavLink,
    JetLabel,
    JetInput,
    JetInputError,
    JetConfirmationModal,
    JetSecondaryButton,
    JetDangerButton,
  },
})
export default class Dashboard extends Vue {
    @Prop() modpacks!: any;

    deleteModpackId: string = null;

    processing = false;

    name: string = null;

    /**
     * TODO: Make utils for this feature
     *
     *
     * Format bytes as human-readable text.
     *
     * @param bytes Number of bytes.
     * @param si True to use metric (SI) units, aka powers of 1000. False to use
     *           binary (IEC), aka powers of 1024.
     * @param dp Number of decimal places to display.
     *
     * @return Formatted string.
     */
    humanFileSize(bytes: number, si = false, dp = 1) {
      const thresh = si ? 1000 : 1024

      if (Math.abs(bytes) < thresh) {
        return `${bytes} B`
      }

      const units = si
        ? ['kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB']
        : ['KiB', 'MiB', 'GiB', 'TiB', 'PiB', 'EiB', 'ZiB', 'YiB']
      let u = -1
      const r = 10 ** dp

      do {
        // eslint-disable-next-line no-param-reassign
        bytes /= thresh
        // eslint-disable-next-line no-plusplus
        ++u
      } while (Math.round(Math.abs(bytes) * r) / r >= thresh && u < units.length - 1)

      return `${bytes.toFixed(dp)} ${units[u]}`
    }

    async deleteModpack() {
      this.processing = true
      try {
        await this.$axios.delete(
          // @ts-ignore
          route('modpacks.destroy', this.deleteModpackId),
        )
        this.$inertia.reload({ only: ['modpacks'] })
      } catch (e) {
        console.error(e)
      }
      this.processing = false
      this.deleteModpackId = null
    }

    async createModpack() {
      this.processing = true
      try {
        await this.$axios.post(
          // @ts-ignore
          route('modpacks.store'),
          {
            name: this.name,
          },
        )
        this.$inertia.reload({ only: ['modpacks'] })
      } catch (e) {
        console.error(e)
      }

      this.processing = false
    }
}
</script>

<style scoped>

</style>
