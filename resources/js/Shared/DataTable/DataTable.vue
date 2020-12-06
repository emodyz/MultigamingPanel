<template>
    <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow-md overflow-hidden border border-gray-200 sm:rounded-lg divide-y divide-gray-200">
                    <jet-input class="w-1/3 my-3 mx-6" type="search" placeholder="Search..." v-model="search"></jet-input>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th v-if="!(_.isEmpty(dataObject.data))" v-for="item in headers" scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ item.title }}
                            </th>
                            <th v-if="actions.enabled && !(_.isEmpty(dataObject.data))"
                                scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                            <th v-else class="px-4 py-2">Search query</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-if="_.isEmpty(dataObject.data)">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">No result matching "{{ search }}"</div>
                                </td>
                            </tr>

                            <tr v-else v-for="(item, index) in dataObject.data">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500" v-for="{ key, type } in headers">
                                    <span v-if="type === 'Index'" class="text-md text-gray-600">
                                        {{ index+1 }}
                                    </span>
                                    <span v-else-if="type === 'Date.Formatted'">
                                        {{ $moment(item[key]).format('LLL') }}
                                    </span>
                                    <span v-else-if="type === 'Date.FromNow'">
                                        {{ $moment(item[key]).fromNow() }}
                                    </span>
                                    <dt-user-profile v-else-if="type === 'User.Profile'" :name="item.name" :email="item.email" :profile_photo_url="item.profile_photo_url"/>
                                    <div v-else-if="type === 'User.Status'">
                                        <span v-if="item.email_verified_at" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Active
                                        </span>
                                        <span v-else class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                            Awaiting Email Validation
                                        </span>
                                    </div>
                                    <span v-else>
                                        {{ item[key] }}
                                    </span>
                                </td>
                                <td v-if="actions.enabled" class="px-6 py-4 whitespace-nowrap text-left text-sm font-medium divide-x divide-gray-200">
                                    <a @click.prevent="goToShow(item.id)" v-if="actions.show.enabled"
                                       href="#"
                                       :class="`text-${actions.show.color} hover:text-${actions.show.hvColor} pr-1`">
                                        {{ actions.show.displayName }}
                                    </a>
                                    <a @click.prevent="goToEdit(item.id)" v-if="actions.edit.enabled"
                                       href="#"
                                       :class="`text-${actions.edit.color} hover:text-${actions.edit.hvColor} pl-2 pr-1`">
                                        {{ actions.edit.displayName }}
                                    </a>
                                    <a @click.prevent="initiateDestruction(item.id)" v-if="actions.destroy.enabled"
                                       href="#"
                                       :class="`text-${actions.destroy.color} hover:text-${actions.destroy.hvColor} pl-2`">
                                        {{ actions.destroy.displayName }}
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Destroy Action Confirmation Modal -->
        <jet-confirmation-modal :show="uuidBeingDestroyed" @close="uuidBeingDestroyed = null">
            <template #title>
                Delete
            </template>

            <template #content>
                Are you sure you would like to delete this item ?
                <br/>
                #: {{ uuidBeingDestroyed }}
            </template>

            <template #footer>
                <jet-secondary-button @click.native="uuidBeingDestroyed = null">
                    Nevermind
                </jet-secondary-button>

                <jet-danger-button class="ml-2" @click.native="goToDestroy(uuidBeingDestroyed)" :class="{ 'opacity-25': destructionInProgress }" :disabled="destructionInProgress">
                    Delete
                </jet-danger-button>
            </template>
        </jet-confirmation-modal>
    </div>
</template>

<script lang="ts">
import {Vue, Component, Prop, Watch} from 'vue-property-decorator'
import { Inertia } from "@inertiajs/inertia"
import _ from 'lodash'
import { stringify } from 'qs'
import Pagination from "@/Shared/Pagination/Pagination.vue"
import JetInput from "@/Jetstream/Input.vue"
import jetButton from "@/Jetstream/Button.vue"
import JetConfirmationModal from "@/Jetstream/ConfirmationModal.vue"
import JetDangerButton from "@/Jetstream/DangerButton.vue"
import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue"
import {DataTableActionsOptions} from "@/Shared/DataTable/Types/DataTableActionsOptions"
import {defaultActionsOptions} from "@/Shared/DataTable/Types/defaults"
import DtUserProfile from "@/Shared/DataTable/Components/UserProfile.vue";

// TODO: Extract interfaces and permission check in their appropriate file

@Component({
    components: {
        jetButton,
        Pagination,
        JetInput,
        JetConfirmationModal,
        JetDangerButton,
        JetSecondaryButton,
        DtUserProfile
    },
})
export default class DataTable extends Vue {
    @Prop() readonly UserPermissions!: Array<string> | null
    @Prop() readonly headers!: null | object
    @Prop() readonly dataObject!: null | object
    @Prop() readonly queryUrl: string
    @Prop() readonly queryParam: string
    @Prop() readonly initialQuery!: null | string
    @Prop({
        type: Object,
        default: () => defaultActionsOptions
    }) readonly actions!: DataTableActionsOptions

    search = this.initialQuery

    uuidBeingDestroyed: string | number | null = null
    destructionInProgress = false

    @Watch('search')
    onSearchChanged = _.debounce((val, old) => {
        const query = stringify({
            search: val || undefined,
        });
        Inertia.visit(query ? `${this.queryUrl}?${query}` : this.queryUrl, {
            preserveScroll: true,
            preserveState: true,
            only: [this.queryParam],
        });
    }, 250)

    goToShow(id: string | number) {
        Inertia.visit(`${this.actions.baseUrl}/${id}/${this.actions.show.path ? this.actions.show.path : ''}`, { preserveScroll: true })
    }

    goToEdit(id: string | number) {
        Inertia.visit(`${this.actions.baseUrl}/${id}/${this.actions.edit.path}`, { preserveScroll: true })
    }

    initiateDestruction(id: string | number) {
        this.uuidBeingDestroyed = id
    }

    goToDestroy(id: string | number) {
        Inertia.delete(`${this.actions.baseUrl}/${id}/${this.actions.show.path ? this.actions.show.path : ''}`, { preserveScroll: true })
    }

    checkPermissions() {
        if(this.actions.show.enabled && this.actions.show.permission) {
            !(_.includes(this.UserPermissions, this.actions.show.permission)) && !(_.includes(this.UserPermissions, '*')) ? this.actions.show.enabled = false : null
        }
        if(this.actions.edit.enabled && this.actions.edit.permission) {
            !(_.includes(this.UserPermissions, this.actions.edit.permission)) && !(_.includes(this.UserPermissions, '*')) ? this.actions.edit.enabled = false : null
        }
        if(this.actions.destroy.enabled && this.actions.destroy.permission) {
            !(_.includes(this.UserPermissions, this.actions.destroy.permission)) && !(_.includes(this.UserPermissions, '*')) ? this.actions.destroy.enabled = false : null
        }
    }

    created() {
        this.checkPermissions()
    }
}
</script>
