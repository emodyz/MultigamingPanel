<template>
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

// TODO: Check permissions before displaying actions

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

    created() {
        // console.log(this.dataObject)
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
        bgColor?: string,
    },
    edit: {
        enabled: boolean,
        displayName?: string,
        permission?: string,
        path?: string,
        icon?: string,
        color?: string,
        bgColor?: string,
    },
    destroy: {
        enabled: boolean,
        displayName?: string,
        permission?: string,
        path?: string,
        icon?: string,
        color?: string,
        bgColor?: string,
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
