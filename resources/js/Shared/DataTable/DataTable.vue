<template>
    <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow-md overflow-hidden border border-gray-200 sm:rounded-lg divide-y divide-gray-200">
                    <jet-input class="w-1/3 my-3 mx-6 border-gray-200" type="search" placeholder="Search..."
                               v-model="search"></jet-input>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th v-if="!(_.isEmpty(dataObject.data))" v-for="item in headers" scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <span @click.prevent="handleOrderBy(item.key)" v-if="item.key !== 'index'" class="flex flex-row  hover:cursor-pointer">
                                    {{ item.title }}
                                    <svg v-if="orderBy.key === item.key && orderBy.direction === 'desc'" class="w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                                    <svg v-if="orderBy.key === item.key && orderBy.direction === 'asc'" class="w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd" /></svg>
                                </span>
                                <span v-else>
                                    {{ item.title }}
                                </span>
                            </th>
                            <th v-if="actions.enabled && !(_.isEmpty(dataObject.data))"
                                scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                            <th v-else-if="_.isEmpty(dataObject.data)" class="px-4 py-2">Search query</th>
                            <th v-else class="px-4 py-2">Page {{ pageNumber }}</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                        <tr v-if="pageNumber > dataObject.links.length || pageNumber < 1">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">Page n° {{ pageNumber }} is out of range</div>
                            </td>
                        </tr>
                        <tr v-else-if="_.isEmpty(dataObject.data)">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">No result matching "{{ search }}"</div>
                            </td>
                        </tr>
                        <tr v-else v-for="(item, index) in dataObject.data">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"
                                v-for="{ key, type } in headers">
                                    <span v-if="type === 'Index'" class="text-md text-gray-600">
                                        {{ ((pageNumber * 10) - 10) + (index + 1) }}
                                    </span>
                                <dt-date v-else-if="_.startsWith(type, 'Date')" :date="item[key]" :type="type"/>
                                <dt-user-profile v-else-if="type === 'User.Profile'" :name="item.name"
                                                 :email="item.email" :profile_photo_url="item.profile_photo_url"/>
                                <dt-user-status v-else-if="type === 'User.Status'"
                                                :email_verified_at="item.email_verified_at"/>
                                <span v-else>
                                        {{ item[key] }}
                                    </span>
                            </td>
                            <td v-if="actions.enabled" class="px-6 py-4 whitespace-nowrap">
                                <dt-actions
                                    :actions="actions"
                                    :item="{
                                            id: item.id,
                                            type: dataType ? dataType : false,
                                            metaData: dataType ? initActionsMetaData(item) : null,
                                        }"
                                    :user-permissions="UserPermissions"/>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <pagination class="px-6 py-3" :links="dataObject.links" :total-item-count="totalItemCount"
                                :query-param="queryParam"></pagination>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import {Vue, Component, Prop, Watch} from 'vue-property-decorator'
import {Inertia} from "@inertiajs/inertia"
import _ from 'lodash'
import qs, {stringify} from 'qs'
import Pagination from "@/Shared/Pagination/Pagination.vue"
import JetInput from "@/Jetstream/Input.vue"
import {DataTableActionsOptions} from "@/Shared/DataTable/Types/DataTableActionsOptions"
import DtUserProfile from "@/Shared/DataTable/Components/UserProfile.vue"
import DtUserStatus from "@/Shared/DataTable/Components/UserStatus.vue"
import DtDate from "@/Shared/DataTable/Components/Date.vue"
import DtActions from "@/Shared/DataTable/Components/Actions.vue"
import {User} from "@/Shared/DataTable/Types/User";
import {PaginatedDate} from "@/Shared/DataTable/Types/PaginatedData";
import {DataTableHeader} from "@/Shared/DataTable/Types/DataTableHeader";

// TODO: Extract permissions checks in their appropriate file

@Component({
    components: {
        Pagination,
        JetInput,
        DtUserProfile,
        DtUserStatus,
        DtDate,
        DtActions
    },
})
export default class DataTable extends Vue {
    @Prop() readonly UserPermissions!: Array<string> | null
    @Prop({type: Array, required: true}) readonly headers!: Array<DataTableHeader>
    @Prop({type: Object, required: true}) readonly dataObject!: PaginatedDate
    @Prop() readonly dataType!: null | string
    @Prop({type: Number, required: true}) readonly totalItemCount!: number
    @Prop({type: String, required: true}) readonly queryUrl: string
    @Prop({type: String, required: true}) readonly queryParam: string
    @Prop({type: String, default: ''}) readonly initialQuery!: string
    @Prop({type: Object}) readonly actions!: DataTableActionsOptions

    query = qs.parse(window.location.search.slice(1))

    pageNumber = this.query.page ? this.query.page : 1

    orderBy: any = {
        key: null,
        direction: 'none'
    }
    @Watch('orderBy')
    onOrderByChanged = _.debounce((val, old) => {
        const query = stringify({
            search: this.search,
            orderBy: val.key ? val : null,
        });
        Inertia.visit(query ? `${this.queryUrl}?${query}` : this.queryUrl, {
            preserveScroll: true,
            preserveState: true,
            only: [this.queryParam, 'totalItemCount'],
        });
    }, 250)

    search = this.initialQuery
    @Watch('search')
    onSearchChanged = _.debounce((val, old) => {
        const query = stringify({
            search: val || null,
            orderBy: this.orderBy.key ? this.orderBy : null,
        });
        Inertia.visit(query ? `${this.queryUrl}?${query}` : this.queryUrl, {
            preserveScroll: true,
            preserveState: true,
            only: [this.queryParam, 'totalItemCount'],
        });
    }, 250)

    initActionsMetaData(item: object): User | object {
        switch (this.dataType) {
            case 'Users':
                return item
        }
    }

    handleOrderBy(key: any) {
        switch (this.orderBy.direction) {
            case 'desc':
                this.orderBy = {
                    key: key,
                    direction: 'asc'
                }
                break
            case 'asc':
                this.orderBy = {
                    key: null,
                    direction: 'none'
                }
                break
            default:
                this.orderBy = {
                    key: key,
                    direction: 'desc'
                }
                break
        }
    }

    created() {
        // console.log(this.dataObject)
    }
}
</script>
