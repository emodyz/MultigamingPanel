<!-- <template>
    <div>
        <jet-input class="w-1/4" type="search" placeholder="Search..." v-model="search"></jet-input>
        <table class="w-full table-auto">
            <thead>
                <tr>
                    <th v-if="!(_.isEmpty(dataObject.data))" v-for="item in headers">
                        {{ item.title }}
                    </th>
                    <th v-if="actions.enabled && !(_.isEmpty(dataObject.data))" class="px-4 py-2">Actions</th>
                    <th v-else class="px-4 py-2">Search query</th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="_.isEmpty(dataObject.data)">
                    <td class="border px-4 py-2 text-center text-gray-500">No result matching "{{ search }}"</td>
                </tr>
                <tr v-else v-for="(item, index) in dataObject.data">
                    <th scope="row">
                        {{ index+1 }}
                    </th>
                    <td class="border px-4 py-2" v-for="{ key, type } in headers.slice(1)">
                        <span v-if="type === 'Date.Formatted'">
                            {{ $moment(item[key]).format('LLL') }}
                        </span>
                        <span v-else-if="type === 'Date.FromNow'">
                            {{ $moment(item[key]).fromNow() }}
                        </span>
                        <span v-else>
                            {{ item[key] }}
                        </span>
                    </td>
                    <td v-if="actions.enabled" class="border px-4 py-2">
                        <jet-button @click.native.prevent="goToShow(item.id)" v-if="actions.show.enabled" :class="`text-${actions.show.color} bg-${actions.show.bgColor}`">
                            {{ actions.show.displayName }}
                        </jet-button>
                        <jet-button @click.native.prevent="goToEdit(item.id)" v-if="actions.edit.enabled" :class="`text-${actions.edit.color} bg-${actions.edit.bgColor}`">
                            {{ actions.edit.displayName }}
                        </jet-button>
                        <jet-button @click.native.prevent="initiateDestruction(item.id)" v-if="actions.destroy.enabled" :class="`text-${actions.destroy.color} bg-${actions.destroy.bgColor}`">
                            {{ actions.destroy.displayName }}
                        </jet-button>
                    </td>
                </tr>
            </tbody>
        </table>
        <pagination class="justify-self-start" :links="dataObject.links"></pagination>
    </div>
</template>
-->

<template>
    <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow-md overflow-hidden border-b border-gray-200 sm:rounded-lg divide-y divide-gray-200">
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
                                    <div v-else-if="type === 'User.Profile'" class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <img class="h-10 w-10 rounded-full" :src="item.profile_photo_url" :alt="`Avatar of user ${item.name}`">
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ item.name }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ item.email }}
                                            </div>
                                        </div>
                                    </div>
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

                            <!-- <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=facearea&amp;facepad=4&amp;w=256&amp;h=256&amp;q=60" alt="">
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                Jane Cooper
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                jane.cooper@example.com
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">Regional Paradigm Technician</div>
                                    <div class="text-sm text-gray-500">Optimization</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Active
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    Admin
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium divide-x divide-gray-200">
                                    <a href="#" class="text-green-600 hover:text-green-900 pr-1">Show</a>
                                    <a href="#" class="text-indigo-600 hover:text-indigo-900 pl-2 pr-1">Edit</a>
                                    <a href="#" class="text-red-600 hover:text-red-900 pl-2">Delete</a>
                                </td>
                            </tr> -->

                        <!-- More rows... -->
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
import Pagination from "@/Shared/Pagination.vue";
import JetInput from "@/Jetstream/Input.vue";

import {Vue, Component, Prop, Watch} from 'vue-property-decorator'

import { Inertia } from "@inertiajs/inertia";
import debounce from 'lodash/debounce';
import { stringify } from 'qs';
import jetButton from "@/Jetstream/Button.vue";
import JetConfirmationModal from "@/Jetstream/ConfirmationModal.vue";
import JetDangerButton from "@/Jetstream/DangerButton.vue";
import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue";
import _ from "lodash";

// TODO: Extract interfaces and permission check in their appropriate file

@Component({
    components: {
        jetButton,
        Pagination,
        JetInput,
        JetConfirmationModal,
        JetDangerButton,
        JetSecondaryButton
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
        default: () => defaultActions
    }) readonly actions!: dataTableActionsOption

    search = this.initialQuery

    @Watch('search')
    onSearchChanged = debounce((val, old) => {
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

    uuidBeingDestroyed: string | number | null = null
    destructionInProgress = false

    initiateDestruction(id: string | number) {
        this.uuidBeingDestroyed = id;
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

export interface dataTableActionsOption {
    enabled: boolean,
    baseUrl?: string,
    show: {
        enabled: boolean,
        displayName?: string,
        permission?: string,
        path?: string,
        icon?: string,
        color?: string,
        hvColor?: string,
    },
    edit: {
        enabled: boolean,
        displayName?: string,
        permission?: string,
        path?: string,
        icon?: string,
        color?: string,
        hvColor?: string,
    },
    destroy: {
        enabled: boolean,
        displayName?: string,
        permission?: string,
        path?: string,
        icon?: string,
        color?: string,
        hvColor?: string,
    }
}
const defaultActions = {
    enabled: false,
    baseUrl: '',
    show: {
        enabled:  false,
        displayName: 'See',
        permission: '',
        path: '',
        icon: '',
        color: 'white',
        bgColor: 'green-500',
    },
    edit: {
        enabled: false,
        displayName: 'Edit',
        permission: '',
        path: 'edit',
        icon: '',
        color: 'white',
        bgColor: 'blue-500',
    },
    destroy: {
        enabled: false,
        displayName: 'Delete',
        permission: '',
        path: '',
        icon: '',
        color: 'white',
        bgColor: 'red-500',
    },
}
</script>
