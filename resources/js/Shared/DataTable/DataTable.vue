<template>
  <div class="flex flex-col">
    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
      <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
        <div class="shadow-md overflow-hidden border border-gray-200 sm:rounded-lg divide-y divide-gray-200">
          <div class="w-full flex flex-row">
              <jet-input
                      v-model="search"
                      class="w-1/3 my-3 mx-6 border-gray-200"
                      type="search"
                      placeholder="Search..."
              />
              <div class="w-1/3 my-3 ml-auto mr-6 border-gray-200 flex flex-row items-center align-middle">
                  <slot name="action"/>
              </div>
          </div>
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
                      v-if="item.key !== 'index' && item.order !== false"
                      class="flex flex-row  hover:cursor-pointer"
                      @click.prevent="handleOrderBy(item.key)"
                  >
                      {{ item.title }}
                      <chevron-down v-show="order.key === item.key && order.direction === 'desc'"/>
                      <chevron-up v-show="order.key === item.key && order.direction === 'asc'"/>
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
                  v-for="{ key, component, options, dataAccessors } in headers"
                  :key="key"
                  class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"
              >
                <span
                    :key="key"
                    v-if="component === 'Index'"
                    class="text-md text-gray-600"
                >
                  {{ ((pageNumber * 10) - 10) + (index + 1) }}
                </span>
                <component v-else
                           :key="key"
                           :itemKey="key"
                           :is="getRowComponent(component)"
                           :data="item"
                           :options="options"
                           :dataAccessors="dataAccessors"/>
              </td>
              <td
                  v-if="actions.enabled"
                  class="px-6 py-4 whitespace-nowrap"
              >
                <dt-actions
                    :options="actions"
                    :item="item"
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
import DtDefaultRow from '@/Shared/DataTable/Components/DefaultRow.vue'
import DtActions from '@/Shared/DataTable/Components/Actions.vue'
import { PaginatedDate } from '@/Shared/DataTable/Types/PaginatedData'
import { DataTableHeader } from '@/Shared/DataTable/Types/DataTableHeader'
import Cerberus from '@/Mixins/Cerberus'
import ChevronUp from '@/Shared/Svgs/ChevronUp.vue'
import ChevronDown from '@/Shared/Svgs/ChevronDown.vue'
import Helpers from '@/Mixins/Helpers'

@Component({
  components: {
    Pagination,
    JetInput,
    ChevronUp,
    ChevronDown,
    DtActions,
  },
})
export default class DataTable extends Mixins(Cerberus, Helpers) {
  @Prop({
    type: Array,
    required: true,
  }) readonly headers!: Array<DataTableHeader>

  @Prop({
    type: Object,
    required: true,
  }) readonly dataObject!: PaginatedDate

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

  /**
   * TODO: Simply pass the item object as data and the accessors to a component instance provided by the header and let the individual component deal with it to reduce boilerplate
   */

  getRowComponent(_comp: any): any {
    return !this.doesNotExist(_comp) ? _comp : DtDefaultRow
  }

  /**
  getWithAccs(item: any, acss: any) {
    return acss.split('.')
      .reduce((acc: any, part: any) => acc && acc[part], item)
  }

  getRowComponentProps(_item: any, _type: string | null, key: any, _dataAccs: any = null): any {
    switch (this.getRowComponent(_type)) {
      default:
        return {
          data: key.split('.')
            .reduce((acc: any, part: any) => acc && acc[part], _item),
        }
    }
  }
   */

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
