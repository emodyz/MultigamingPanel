<template>
    <div class="ml-auto">
        <button
                :disabled="opened"
                class="
      disabled:cursor-not-allowed disabled:opacity-75 inline-flex items-center px-4 py-2 bg-gray-800 border
      border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-gray-700
      active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-400 transition ease-in-out
      duration-150 text-base"
                type="button"
                @click="open"
        >
            Create a new modpack
            <FolderAdd class="ml-2 h-6 w-6"/>
        </button>

        <div v-if="opened" class="fixed z-10 inset-0">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0 rounded-lg">
                <div aria-hidden="true" class="fixed inset-0 transition-opacity">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>
                <span aria-hidden="true" class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                <div v-click-outside="close" aria-labelledby="modal-headline"
                     aria-modal="true"
                     class="inline-block align-bottom bg-white rounded-lg text-left shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                     role="dialog">
                    <form @submit.prevent="createModPack">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 rounded-lg">
                        <span class="text-md font-bold">
                            Create a new ModPack
                        </span>
                            <div class="flex flex-col mt-3">

                                <jet-label for="name" value="Name"/>
                                <jet-input
                                        id="name"
                                        v-model="form.name"
                                        autofocus
                                        class="mt-1 block w-full"
                                        placeholder="Enter Name"
                                        type="text"/>
                                <jet-input-error :message="form.errors.name"/>

                                <jet-label class="mt-3" for="servers" value="Game"/>
                                <select
                                        id="servers"
                                        v-model="form.game"
                                        class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option :value="null" disabled>Select a game</option>
                                    <option v-for="game of games" :key="game.id" :value="game.id">{{game.name}}</option>
                                </select>
                                <jet-input-error :message="form.errors.game"/>

                                <div v-if="form.game">
                                    <jet-label class="mt-3" for="servers" value="Assigned Servers"/>
                                    <multi-select
                                            v-model="form.servers"
                                            :options-list="serversOptions"
                                            :tags="true"
                                            placeholder="Chose a server"
                                    />
                                    <jet-input-error :message="form.errors.servers"/>
                                </div>

                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse rounded-b-lg">
                            <jet-button
                                    :class="{ 'opacity-25': form.processing }"
                                    :disabled="form.processing"
                                    class="ml-2">
                                <spinner v-if="form.processing"/>
                                Create
                            </jet-button>
                            <jet-secondary-button type="button" @click="close">
                                Cancel
                            </jet-secondary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import {
  Component, Mixins, Prop, Watch,
} from 'vue-property-decorator'
import Route from '@/Mixins/Route'
import DocumentAdd from '@/Shared/Svgs/DocumentAdd.vue'
import JetLabel from '@/Jetstream/Label.vue'
import JetInput from '@/Jetstream/Input.vue'
import JetInputError from '@/Jetstream/InputError.vue'
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'
import JetButton from '@/Jetstream/Button.vue'
// @ts-ignore
import vClickOutside from 'v-click-outside'
import MultiSelect from '@/Shared/Forms/MultiSelect.vue'
import { MultiSelectOptions } from '@/Shared/Forms/Types/MultiSelectOptions'
import MultiSelectServerRow from '@/Shared/Forms/MultiSelectServerRow.vue'
import Spinner from '@/Shared/Svgs/Spinner.vue'
import FolderAdd from '@/Shared/Svgs/FolderAdd.vue'

@Component({
  components: {
    FolderAdd,
    Spinner,
    MultiSelect,
    JetButton,
    JetLabel,
    JetInput,
    JetInputError,
    JetSecondaryButton,
    DocumentAdd,
  },
  directives: {
    clickOutside: vClickOutside.directive,
  },
})
export default class CreateModPackModal extends Mixins(Route) {
  @Prop() readonly games!: any[]

  @Prop() readonly servers!: any[]

  opened = false

  form = this.$inertia.form({
    name: '',
    game: null,
    servers: [] as any,
  })

  serversOptions: MultiSelectOptions = this.initServerOptions(null)

  @Watch('form.game')
  onGameUpdated(gameId: string | null) {
    this.serversOptions = this.initServerOptions(gameId)
  }

  open() {
    this.opened = true
  }

  close() {
    this.opened = false

    this.form.name = ''
    this.form.game = null
    this.form.servers = []

    this.serversOptions = []
  }

  createModPack() {
    this.form.post(this.route('modpacks.store'), {
      preserveScroll: true,
      preserveState: true,
      onSuccess: () => {
        this.close()
      },
    })
  }

  initServerOptions(gameId: string): MultiSelectOptions {
    const opts: MultiSelectOptions = []
    this.servers
      .filter((server: any) => server.game.id === gameId)
      .forEach((server: any) => {
        opts.push({
          name: server.name,
          value: server.id,
          selected: false,
          component: {
            instance: MultiSelectServerRow,
            properties: {
              logo: server.logo_url,
              game: {
                name: server.game.name,
                logo: server.game.logo_url,
                identifier: server.game.identifier,
              },
            },
          },
        })
      })
    return opts
  }
}

</script>

<style scoped>

</style>
