<template>
  <div class="flex flex-col">
    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
      <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
        <div class="shadow-md overflow-hidden border border-gray-200 sm:rounded-lg divide-y divide-gray-200">
          <jet-input
              v-model="search"
              class="w-1/3 my-3 mx-6 border-gray-200"
              type="search"
              placeholder="Search..."
          />
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
            <tr v-if="!(_.isEmpty(dataObject.data))">
              <th
                  v-for="item in headers"
                  :key="item.key"
                  scope="col"
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
              >
                  <span
                      v-if="item.key !== 'index'"
                      class="flex flex-row  hover:cursor-pointer"
                      @click.prevent="handleOrderBy(item.key)"
                  >
                    {{ item.title }}
                    <svg
                        v-show="order.key === item.key && order.direction === 'desc'"
                        class="w-4"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                    ><path
                        fill-rule="evenodd"
                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                        clip-rule="evenodd"
                    /></svg>
                    <svg
                        v-show="order.key === item.key && order.direction === 'asc'"
                        class="w-4"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                    ><path
                        fill-rule="evenodd"
                        d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z"
                        clip-rule="evenodd"
                    /></svg>
                  </span>
                <span v-else>
                    {{ item.title }}
                  </span>
              </th>
              <th
                  v-if="actions.enabled && !(_.isEmpty(dataObject.data))"
                  scope="col"
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
              >
                Actions
              </th>
              <th
                  v-else-if="_.isEmpty(dataObject.data)"
                  class="px-4 py-2"
              >
                Search query
              </th>
              <th
                  v-else
                  class="px-4 py-2"
              >
                Page {{ pageNumber }}
              </th>
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
            <tr v-if="pageNumber > (totalItemCount / 10) + 10 || pageNumber < 1">
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-900">
                  Page n° {{ pageNumber }} is out of range
                </div>
              </td>
            </tr>
            <tr v-else-if="_.isEmpty(dataObject.data)">
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-900">
                  No result matching "{{ search }}"
                </div>
              </td>
            </tr>
            <tr
                v-for="(item, index) in dataObject.data"
                :key="index"
                v-else>
              <td
                  v-for="{ key, type } in headers"
                  :key="key"
                  class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"
              >
                <span
                    :key="key"
                    v-if="type === 'Index'"
                    class="text-md text-gray-600"
                >
                  {{ ((pageNumber * 10) - 10) + (index + 1) }}
                </span>
                <component :key="key" v-else-if="type !== ''"
                           :is="getRowComponent(type)"
                           v-bind="{...getRowComponentProps(item, type, key)}"/>
              </td>
              <td
                  v-if="actions.enabled"
                  class="px-6 py-4 whitespace-nowrap"
              >
                <dt-actions
                    :actions-options="actions"
                    :item="{
                      id: item.id,
                      type: dataType ? dataType : false,
                      metaData: dataType ? initActionsMetaData(item) : null,
                    }"
                />
              </td>
            </tr>
            </tbody>
          </table>
          <pagination
              class="px-6 py-3"
              :links="dataObject.links"
              :total-item-count="totalItemCount"
              :query-param="queryParam"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import {
  Mixins, Component, Prop, Watch,
} from 'vue-property-decorator'
import { Inertia } from '@inertiajs/inertia'
import _ from 'lodash'
import qs, { stringify } from 'qs'
import Pagination from '@/Shared/Pagination/Pagination.vue'
import JetInput from '@/Jetstream/Input.vue'
import { DataTableActionsOptions } from '@/Shared/DataTable/Types/DataTableActionsOptions'
import DtUserProfile from '@/Shared/DataTable/Components/UserProfile.vue'
import DtUserStatus from '@/Shared/DataTable/Components/UserStatus.vue'
import DtDate from '@/Shared/DataTable/Components/Date.vue'
import DtDefaultRow from '@/Shared/DataTable/Components/DefaultRow.vue'
import DtActions from '@/Shared/DataTable/Components/Actions.vue'
import { User } from '@/Shared/DataTable/Types/User'
import { PaginatedDate } from '@/Shared/DataTable/Types/PaginatedData'
import { DataTableHeader } from '@/Shared/DataTable/Types/DataTableHeader'
import Cerberus from '@/Mixins/Cerberus'

@Component({
  components: {
    Pagination,
    JetInput,
    DtUserProfile,
    DtUserStatus,
    DtDate,
    DtDefaultRow,
    DtActions,
  },
})
export default class DataTable extends Mixins(Cerberus) {
  @Prop({
    type: Array,
    required: true,
  }) readonly headers!: Array<DataTableHeader>

  @Prop({
    type: Object,
    required: true,
  }) readonly dataObject!: PaginatedDate

  @Prop() readonly dataType!: null | string

  @Prop({
    type: Number,
    required: true,
  }) readonly totalItemCount!: number

  @Prop({
    type: String,
    required: true,
  }) readonly queryUrl: string

  @Prop({
    type: String,
    required: true,
  }) readonly queryParam: string

  @Prop({
    type: String,
    default: '',
  }) readonly initialQuery!: string

  @Prop({ type: Object }) readonly actions!: DataTableActionsOptions

  query: any = qs.parse(window.location.search.slice(1))

  pageNumber = this.query.page ? this.query.page : 1

  search = this.initialQuery

  @Watch('search')
  onSearchChanged = _.debounce((val) => {
    this.search = val
    const query = stringify({
      search: val || null,
      // orderBy: this.orderBy.key ? this.orderBy : null,
      page: this.pageNumber,
    })
    Inertia.visit(query ? `${this.queryUrl}?${query}` : this.queryUrl, {
      preserveScroll: true,
      preserveState: true,
      only: [this.queryParam, 'totalItemCount'],
      onFinish: () => {
        this.resetOrderBy()
      },
    })
  }, 250)

  order: any = this.query.orderBy ? this.query.orderBy : {
    key: null,
    direction: null,
  }

  // orderBy: any = {key: null, direction: 'none'}
  @Watch('order')
  onOrderChanged = _.debounce((val, old) => {
    if (val !== old) {
      const orderBy = stringify({
        search: this.search,
        orderBy: val.key ? val : null,
        page: this.pageNumber,
      })
      Inertia.visit(orderBy ? `${this.queryUrl}?${orderBy}` : this.queryUrl, {
        preserveScroll: true,
        preserveState: true,
        only: [this.queryParam, 'totalItemCount'],
      })
    }
  }, 250)

  // eslint-disable-next-line consistent-return
  initActionsMetaData(item: object): User | object {
    // eslint-disable-next-line default-case
    switch (this.dataType) {
      case 'Users':
        return item
    }
  }

  resetOrderBy() {
    this.order = {
      key: null,
      direction: null,
    }
  }

  handleOrderBy(key: any) {
    switch (this.order.direction) {
      case 'desc':
        this.order = {
          key,
          direction: 'asc',
        }
        break
      case 'asc':
        this.order = {
          key: null,
          direction: null,
        }
        break
      default:
        this.order = {
          key,
          direction: 'desc',
        }
        break
    }
  }

  getRowComponent(_type: string | null): string {
    switch (_type) {
      case 'Date.Formatted':
        return 'DtDate'
      case 'Date.FromNow':
        return 'DtDate'
      case 'User.Profile':
        return 'DtUserProfile'
      case 'User.Status':
        return 'DtUserStatus'
      default:
        return 'DtDefaultRow'
    }
  }

  getRowComponentProps(_item: any, _type: string | null, key: any): any {
    switch (this.getRowComponent(_type)) {
      case 'DtDate':
        return {
          date: _item[key],
          type: _type,
        }
      case 'DtUserProfile':
        return {
          name: _item.name,
          email: _item.email,
          profile_photo_url: _item.profile_photo_url,
        }
      case 'DtUserStatus':
        return { email_verified_at: _item.email_verified_at }
      default:
        return { data: _item[key] }
    }
  }

  checkActionsPermissions() {
    this.actions.actions.forEach(async (item) => {
      if (item.enabled && !_.isEmpty(item.permission)) {
        const i = this.actions.actions.indexOf(item)
        this.actions.actions[i].enabled = await this.Cerberus.can(item.permission)
      }
    })
  }

  // eslint-disable-next-line class-methods-use-this
  created() {
    this.checkActionsPermissions()
    // console.log(this.dataObject)
    // console.log(this.query.orderBy['key'])
  }
}
</script>
